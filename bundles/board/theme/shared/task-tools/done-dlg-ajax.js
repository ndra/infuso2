mod.init(".w3T2t7XKGU", function() {
    
    var $container = $(this);
    $container.submit(function(event) {
        event.preventDefault();
        var time = {};
        $container.find(".time input").each(function() {
            time[$(this).attr("name")] = $(this).val();
        });
        mod($container.find(".time")).formData();
        mod.call({
            cmd: "infuso/board/controller/task/doneTask",
            time: time,
            comment: $container.find(".comment").val(),
            taskId: $container.attr("data:task")
        }, function() {
            $container.window("close");
        });
    });
    
});