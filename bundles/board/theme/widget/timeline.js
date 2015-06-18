mod.init(".Roy1CZU9ev", function() {
    
    $task = $(this).find(".workflow-item");
    
    // Нажатие на задачу
    $task.click(function(event) {
        
        $(this).trigger({
            type: "board/openTask",
            taskId: $(this).attr("data:taskId")
        }); 
        
    });
    
});