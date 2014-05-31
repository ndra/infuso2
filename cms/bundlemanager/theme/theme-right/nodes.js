mod.init(".gdiqqd1vn4 .node", function() {

    var $container = $(this);
    
    $container.find(" > .body > .expander").mousedown(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    // Клик по плюсику - разворачиваем / сворачиваем
    
    $container.find(" > .body > .expander").click(function(e) {
        $container.toggleClass("expanded");
        if($container.hasClass("expanded")) {
            $container.trigger("refresh");
        }
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
    
    $container.on("expand", function(event) {
        event.stopPropagation();
        $container.addClass("expanded");
        $container.trigger("refresh");
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