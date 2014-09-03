mod.init(".sdqg1isQGi", function() {
    
    var $container = $(this);
    
    var select = function(n) {
        $container.find(".tabs-head .tab")
            .removeClass("selected")
            .eq(n)
            .addClass("selected");
        $container.find(".tabs .tab").hide();
        $container.find(".tabs .tab").eq(n).show();        
    }
    
    select(0);
    
    $container.find(".tabs-head .tab").each(function(n) {
        $(this).click(function() {
            select(n);
        })
    });
    
    $container.on("board/project-selector/select", function(event) {
        mod.call({
            cmd:"infuso/board/controller/task/newTask",
            data: {
                projectId: event.projectId,
                parent: $container.attr("data:group")
            }
        }, function(data) {
            $container.trigger({
                type: "board/openTask",
                taskId: data.taskId
            })
        });
    });
    
});
