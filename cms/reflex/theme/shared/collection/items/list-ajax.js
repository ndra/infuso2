mod.init(".x1arvpu0c38", function() {
    
    var $container = $(this);
    
    $container.list();
    
    new Sortable($container.find(".items")[0], {
        handle: ".sort-handle",
        onStart: function () {
            mod.fire("reflex/sort-begin");
        },
        onEnd: function () {
            mod.fire("reflex/sort-end");
        }, onUpdate: function() {
            var priority = [];
            $container.find(".list-item").each(function() {
                priority.push($(this).attr("data:id"));
            });
            mod.call({
                cmd: "infuso/cms/reflex/controller/savePriority",
                priority: priority
            });
        }
    });

});