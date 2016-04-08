mod.init(".MSq4uFuQJA", function() {
    $container = $(this);
    $container.submit(function(event) {
        event.preventDefault();
        var data = mod($container).formData();
        mod.call({
            cmd:"infuso/board/controller/project/save",
            data:data,
            projectId: $container.attr("data:id")
        });
    });
    
});