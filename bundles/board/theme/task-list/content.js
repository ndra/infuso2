mod.init(".MhpEuDh2NX", function() {
    
    var $container = $(this);
    $container.layout();

    var $tabs = $container.find(".center .tab");
    var $center = $container.find(".center");
    
    var selectTab = function(status) {
        
        var num = 0;
        
        $tabs.each(function(n) {
            if($(this).attr("data:id") == status) {
                num = n;
                var $tab = $(this);
                $tab.show();
                setTimeout(function() {
                    $tab.find(".c-task-list").trigger("board/load");
                }, 0);
            }
        });

        $center.stop(true).find(".roller").animate({
            left: - (num * 100) + "%"    
        },"fast", function() {
            $tabs.each(function(n) {
                if(n != num) {
                    $(this).hide();
                }
            });
        });
    };

    mod.on("board/show-status", function(data) {
        selectTab(data.status);
    });
    
    selectTab($container.attr("data:status"));
    
    var task = $container.attr("data:task");
    if(task) {
        $container.trigger({
            type: "board/openTask",
            taskId: task
        });
    }

    
});