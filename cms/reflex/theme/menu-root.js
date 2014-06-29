$(function() {    

    var initNodes = function() {
        $(".pp7cpa1wpc .node").mod("init", function() {            
            var $node = $(this);
            $node.find(".expander:first").click(function() {
                toggleNode($node);
            });
        });
    }
    
    // Раскрывает ноду
    var expandNode = function(node) {
    
        node.addClass("expanded");
        var id = node.attr("data:node-id");
        
        mod.call({
            cmd:"Infuso/Cms/Reflex/Controller/Menu/subdivisions",
            nodeId: id,
            url: window.location.href
        }, function(html) {
            node.children(".subdivisions").show().html(html);
            initNodes();
            //storeExpanded();
        });
    }
    
    // Сворачивает ноду
    var collapseNode = function(node) {
        node.children(".subdivisions").hide();
        node.removeClass("expanded");
    }
    
    // Разворачивает сворачивает ноду автоматически
    var toggleNode = function($node) {
        if(!$node.hasClass("expanded")) {
            expandNode($node);
        } else {
            collapseNode($node);
        }        
e    }

    initNodes();

});