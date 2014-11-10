mod.init(".mcGSvrqQ3m", function() {
    
    var $task = $(this);
    
    // id задачи
    var id = $(this).attr("data:id");
    
    $task.click(function() {
        $(this).trigger({
            type: "board/setGroup",
            group: id
        });
    });
    
    // Нажатие на задачу
    /*$task.click(function(event) {
        
        mod.msg($(event.target).parents(".edit").length);
        
        if($(event.target).filter(".edit").length) {
            $(this).trigger({
                type: "board/openTask",
                taskId: id
            });              
        } else {
            $(this).trigger({
                type: "board/openGroup",
                groupId: id
            });                
        }
  
    }); */
    
});