$(function() {

    $(".ybslv95net").submit(function(e) {
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/board/controller/task/saveTask",
            taskId: $(this).attr("data:task"),
            data:data
        });
    });

});