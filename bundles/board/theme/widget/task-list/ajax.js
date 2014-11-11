mod.init(".task-list-zjnu1r2ofp", function() {
    
    var $container = $(this);
    
    // Сортировка
    if($container.attr("data:sortable") == 1) {
        new Sortable($container[0], {
            draggable: ".task",
            onStart: function(event) {
                window.sortProcessing = true;
            }, onEnd: function(event) {
                window.sortProcessing = false;
            }, onUpdate: function() {
                var priority = [];
                $container.find(".task").each(function() {
                    priority.push($(this).attr("data:id"));
                });
                mod.call({
                    cmd: "infuso/board/controller/task/savePriority",
                    priority: priority
                });
            }
        });
    }
    
    $container.find("> .title .group").click(function() {
        $(this).trigger({
            type: "board/setGroup",
            group: $(this).attr("data:id")
        });
    });
    
});