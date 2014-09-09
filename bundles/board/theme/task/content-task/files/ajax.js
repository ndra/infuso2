mod.init(".wq01orrvbq", function() {
    
    $container = $(this);
    
    $container.find(".file").each(function() {
        
        var file = $(this).attr("data:id");
        
        $(this).find(".delete").click(function() {
            
            if(!confirm("Удалить файл?")) {
                return;
            }
            
            mod.call({
                cmd: "infuso/board/controller/attachment/delete",
                path: file,
                taskId: $container.attr("data:task")
            });
        })
        
         
    });
    
});