mod.init(".lonjnbmi8k", function() {

    var container = $(this);
    var index = container.attr("data:index");

    $(this).find(".create-meta").click(function() {
        mod.call({
            cmd:"infuso/cms/reflex/controller/meta/create",
            index: index
        })
    });

});