mod.init(".ybslv95net", function() {

    var container = $(this);

    container.submit(function(e) {
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/board/controller/task/saveTask",
            taskId: $(this).attr("data:task"),
            data:data
        });
    });

})