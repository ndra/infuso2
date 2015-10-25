mod.init(".ioy1gedqt1", function() {
    
    var $container = $(this);
    
    var reload = function() {
        $container.trigger("route/reload");
    };

    $container.find(".create-object").click(function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/route/create",
            editor: $container.attr("data:editor")
        }, reload);
    });
    
    $container.find(".save").click(function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/route/save",
            editor: $container.attr("data:editor"),
            url: $container.find(".url").val(),
        }, reload);
    });
    
    $container.find(".delete").click(function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/route/delete",
            editor: $container.attr("data:editor")
        }, reload);
    });

});