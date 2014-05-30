mod.init(".zjvrux95g2 .node", function() {

    var container = $(this);
    
    container.find(" > .body > .expander").mousedown(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    container.find(" > .body > .expander").click(function(e) {
    
        var path = container.find(".body").attr("data:id");
        container.toggleClass("expanded");
        
        if(container.hasClass("expanded")) {
            mod.call({
                cmd: "infuso/cms/bundlemanager/controller/files/list",
                path:path
            }, function(html) {
                container.find(" > .subdivisions").html(html);
                container.trigger("updateList");
            });
        }
    });
    
    container.find(".body").dblclick(function(e) {
        container.trigger({
            type: "bundlemanager/openFile",
            path: container.find(".body").attr("data:id")
        });
        e.preventDefault();
    });

});