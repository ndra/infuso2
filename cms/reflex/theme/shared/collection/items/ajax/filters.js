mod.init(".edJEHvd7pc", function() {
    
    $container = $(this);
    
    $container.find("span").click(function() {
        var filter = $(this).attr("data:filter");
        $(this).trigger({
            type: "reflex/setFilter",
            filter: filter
        });
    })
    
})