mod.init(".mcGSvrqQ3m", function() {
    
    var $task = $(this);
    
    // id задачи
    var id = $(this).attr("data:id");
 
    // Нажатие на задачу
    $task.click(function(event) {
        $(this).trigger({
            type: "board/openGroup",
            groupId: id
        });    
    });
    
});