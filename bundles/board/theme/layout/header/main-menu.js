$(function() {

    $(".x55qv4lhb8m .item").on("dragenter", function() {
        $(this).css({
            textDecoration: "underline"
        });
    });
    
    // Перетаскивание задачи в пункт меню (смена статуса)
    $(".x55qv4lhb8m .item").on("drop", function(e) {
        mod.msg(e.originalEvent.dataTransfer.getData("task-id"));
    });
    
    $(".x55qv4lhb8m .new-task").click(function() {
        mod.msg(11111);
        // Создание задачи
        mod.call({
            cmd:"infuso/board/controller/task/newTask",
        }, function(data) {
            console.log(data);
        });
    })

});