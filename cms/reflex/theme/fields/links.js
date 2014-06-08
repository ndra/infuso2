mod.init(".QWQ2cWdbx", function() {
    
    var $container =  $(this);
    $container.find(".add").click(function() {
        $.window({
            call:{ 
                cmd: "infuso/cms/reflex/controller/field/linksAdd",
                editor: $container.attr("data:editor"),
                field: $container.attr("data:field"),
            }
        }).on("links/select", function(event) {
            mod.msg(event.itemID);
        });
    });
    
    
});