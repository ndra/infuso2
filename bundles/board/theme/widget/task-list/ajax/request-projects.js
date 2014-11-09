mod.init(".OhFHTNdpem", function() {
    
    var $container = $(this);
    $container.find(".project").click(function() {
        $(this).trigger({
            type: "board/setPath",
            path: $(this).attr("data:path")
        });
    });
    
    
})