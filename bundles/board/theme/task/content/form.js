mod.init(".ybslv95net", function() {

    var $container = $(this);
    
    var save = function() {
        var data = $container.mod("formData");
        mod.call({
            cmd:"infuso/board/controller/task/saveTask",
            taskId: $container.attr("data:task"),
            data:data
        });
    };

    $container.submit(function(e) {
        e.preventDefault();
        save();
    });
    
    mod.on("keydown", function(event) {
        if(event.which == 83 && event.ctrlKey) {
            save();
            event.preventDefault();
        }
    }, $container);

})