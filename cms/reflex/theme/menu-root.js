$(function() {    

    var initNodes = function() {
        $(".pp7cpa1wpc .node").mod("init", function() {            
            var node = $(this);
            $(this).find(".expander").click(function() {
                toggleNode(node);
            });
        });
    }
    
    // Раскрывает ноду
    var expandNode = function(node) {
    
        node.addClass("expanded");
        var id = node.attr("data:node-id");
        
        var expanded = getExpandedNodes();
       
        mod.call({
            cmd:"Infuso/Cms/Reflex/Controller/Menu/subdivisions",
            nodeId: id,
            url: window.location.href,
            expanded: expanded
        }, function(html) {
            node.children(".subdivisions").show().html(html);
            initNodes();
            storeExpanded();
        });
    }
    
    // Сворачивает ноду
    var collapseNode = function(node) {
        node.children(".subdivisions").hide();
        node.removeClass("expanded");
    }
    
    // Разворачивает сворачивает ноду автлматически
    var toggleNode = function(node) {
        if(!node.hasClass("expanded")) {
            expandNode(node);
        } else {
            collapseNode(node);
        }        
        storeExpanded();
    }
    
    var getExpandedNodes = function() {
        var data = sessionStorage.getItem("reflex/left-menu");
        if(data) {
            return data.split("|||");
        }
        return [];
    }
    
    // Сохраняет список раскрытых нод
    var storeExpanded = function() {
        var nodes = $(".pp7cpa1wpc .node.expanded:visible");
        var idList = [];
        nodes.each(function() {
            if($(this).find(".subdivisions *").length) {
                idList.push($(this).attr("data:node-id"));
            }
        });
        sessionStorage.setItem("reflex/left-menu",idList.join("|||"));
    }
    
    initNodes();
    
    var expanded = getExpandedNodes();
    $(".pp7cpa1wpc .node").each(function() {
        var node = $(this);
        if($.inArray(node.attr("data:node-id"),expanded) != -1) {
            expandNode(node);
        }
    });

});