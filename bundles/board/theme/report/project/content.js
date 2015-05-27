mod.init(".H9IXl57L0B", function() {
     
    var $container = $(this);
    
    $container.find(".text").click(function() {
        // id задачи
        var id = $(this).parent().attr("data:id");
        
        $(this).trigger({
            type: "board/openTask",
            taskId: id
        }); 
        
    });
    
});