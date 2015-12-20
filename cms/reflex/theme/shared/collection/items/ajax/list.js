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
            
            var params = {
                cmd: "infuso/cms/reflex/controller/savePriority",
                collection: $container.attr("data:collection"),
                page: 1,
                priority: priority
            };
            
            $container.trigger({
                type: "reflex/beforeSavePriority",
                params: params
            });
            
            mod.call(params);
        }
    });

});