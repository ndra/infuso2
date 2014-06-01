/*
mod.init(".mwf8wqyh3i .node", function() {

    var $container = $(this);
    
    $container.find(" > .body > .expander").mousedown(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    

    
    // Двойной клик на ноде - редактирование
    
    $container.find(".body").dblclick(function(e) {
        $container.trigger({
            type: "bundlemanager/openTemplate",
            theme: $container.attr("data:theme"),
            template: $container.attr("data:id")
        });
        e.preventDefault();
    });
    

    
    $container.on("refresh", function(event) {
        event.stopPropagation();
        var theme = $container.attr("data:theme");
        var path = $container.attr("data:id");
        mod.call({
            cmd: "infuso/cms/bundlemanager/controller/theme/list",
            theme: theme,
            path: path
        }, function(html) {
            $container.find(" > .subdivisions").html(html);
            $container.trigger("updateList");
        });
    });

});

*/