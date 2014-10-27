mod.init(".ioy1gedqt1", function() {
    
    var $container = $(this);

    $container.find(".create-object").click(function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/route/create",
            editor: $container.attr("data:editor")
        });
    });
    
    $container.find(".save").click(function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/route/save",
            editor: $container.attr("data:editor"),
            url: $container.find(".url").val(),
        });
    });

});