mod.init(".p7jBpDQmdS", function() {
    
    $container = $(this);
    $container.find(".remove").click(function() {
        var id = $(this).parent().attr("data:id");
        $(this).trigger({
            type: "links/remove",
            itemID: id
        });
    });
    
});