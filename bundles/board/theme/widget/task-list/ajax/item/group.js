mod.init(".mcGSvrqQ3m", function() {
    
    var $task = $(this);
    
    // id задачи
    var groupId = $(this).attr("data:group");
    
    $task.click(function() {
        $(this).trigger({
            type: "board/setGroup",
            group: groupId
        });
    });
    
});