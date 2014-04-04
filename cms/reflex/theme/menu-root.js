$(function() {

    var initNodes = function() {
        $(".pp7cpa1wpc .node").mod().init(function() {
            var node = $(this);
            $(this).find(".expand").click(function() {
                expandNode(node);
            });
        });
    }
    
    var expandNode = function(node) {
        var id = node.attr("data:node-id");
        mod.call({
            cmd:"Infuso/Cms/Reflex/Controller/Menu/subdivisions",
            nodeId: id
        }, function(html) {
            node.children(".subdivisions").html(html);
            initNodes();
        });
    }
    
    initNodes();

});