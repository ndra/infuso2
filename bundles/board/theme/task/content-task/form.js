mod.init(".ybslv95net", function() {

    var $container = $(this);
    
    $container.find("textarea").focus();
    
    var save = function() {
        var data = mod($container).formData();
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
    
    $container.find(".file").click(function() {
        $(this).next().click();
    });
    
    $container.find("input[type=file]").change(function() {
        mod.call({
            cmd:"infuso/board/controller/attachment/upload",
            taskId: $container.attr("data:task")
        }, function() {        
        }, {
            files: $container
        });
    });

})