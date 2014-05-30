mod.init(".gdiqqd1vn4 .node", function() {

    var container = $(this);
    
    container.find(" > .body > .expander").mousedown(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    container.find(" > .body > .expander").click(function(e) {
    
        var theme = container.find(".body").attr("data:theme");
        var path = container.find(".body").attr("data:id");
        container.toggleClass("expanded");
        
        if(container.hasClass("expanded")) {
            mod.call({
                cmd: "infuso/cms/bundlemanager/controller/theme/list",
                theme: theme,
                path: path
            }, function(html) {
                container.find(" > .subdivisions").html(html);
                container.trigger("updateList");
            });
        }
    });
    
    container.find(".body").dblclick(function(e) {
        container.trigger({
            type: "bundlemanager/openTemplate",
            theme: container.find(".body").attr("data:theme"),
            template: container.find(".body").attr("data:id")
        });
        e.preventDefault();
    });

});