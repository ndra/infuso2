mod.init(".wLGKYMEfER", function() {

    var $container = $(this);
    var $form = $container.children(".form");
    
    $form.find("textarea").focus();
    
    var save = function() {
        var data = $form.mod("formData");
        mod.call({
            cmd:"infuso/board/controller/task/saveTask",
            taskId: $container.attr("data:task"),
            data:data
        });
    };

    $form.submit(function(e) {
        e.preventDefault();
        save();
    });
    
    mod.on("keydown", function(event) {
        if(event.which == 83 && event.ctrlKey) {
            save();
            event.preventDefault();
        }
    }, $form);

})