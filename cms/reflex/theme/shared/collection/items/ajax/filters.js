mod(".FLQbxUZK3f").init(function() {
    
    var $container = $(this);
    
    $container.find(".configure-filter").click(function() {
        $container.trigger("reflex/options");
    });
    
    $container.find(".clear-filter").click(function() {
        $container.trigger({
            type: "reflex/setFilters",
            filters: null
        });
    });
    
});