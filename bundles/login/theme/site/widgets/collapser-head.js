mod.init(".gcr7LERV9A", function() {
    
    var $container = $(this);
    var id = $container.attr("data:id");
    
    $container.click(function() {
        if($container.hasClass("expanded")) {
            mod.fire("collapser/collapse/" + id);
        } else {
            mod.fire("collapser/expand/" + id);
        }
    });
    
    mod.on("collapser/handle-expand/" + id, function() {
        $container.addClass("expanded");
    });
    
    mod.on("collapser/handle-collapse/" + id, function() {
        $container.removeClass("expanded");
    });
    
});