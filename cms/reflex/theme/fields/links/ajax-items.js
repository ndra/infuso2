mod.init(".p7jBpDQmdS", function() {
    
    var $container = $(this);
    $container.find(".remove").click(function() {
        $(this).parents(".item").first().remove();
        $container.trigger({
            type: "links/remove"
        });
    });
    
    new Sortable($container[0], {
        handle: ".sort-handle",
        onStart: function () {
            mod.fire("reflex/sort-begin");
        },
        onEnd: function () {
            mod.fire("reflex/sort-end");
        }, onUpdate: function() {
            
            $container.trigger({
                type: "links/sort"
            });
        }
    });
    
});