mod.init(".x0kf50uz479", function() {

    $(this).find(".exec").click(function() {
        var $e = $(this);
        mod.call({
            cmd: "infuso/cms/task/controller/runTask",
            taskId: $(this).attr("data:task")
        }, function() {
            $e.trigger("reflex/refresh");    
        });
    });
    
});