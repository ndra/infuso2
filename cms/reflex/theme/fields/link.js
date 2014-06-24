mod.init(".x4qRpzOJXG", function() {
    
    var $container = $(this);
    
    $container.click(function() {
        $.window({
            call:{ 
                cmd: "infuso/cms/reflex/controller/field/linksAdd",
                editor: $container.attr("data:editor"),
                field: $container.attr("data:field"),
            }
        }).on("links/select", function(event) {
            $container.find("input").val(event.itemID);
            $container.find(".title").text(event.title);
        });
    });
})