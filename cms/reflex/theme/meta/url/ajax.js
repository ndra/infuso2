$(function() {

    $(".ioy1gedqt1").mod().init(function() {
    
        var container = $(this);
    
        $(this).find(".create-object").click(function() {
            mod.call({
                cmd: "Infuso/Cms/Reflex/Controller/Route/create",
                editor: container.attr("data:editor")
            });
        });
    });

});