jQuery.fn.tree = function(params) {

    var $tree = $(this);
    
    var node = function($e) {
        $e = $($e);
        while($e.length) {
            if($e.hasClass("node")) {
                return $e;
            }
            $e = $e.parent();
        }
        return $("xxx");
    }
    
    // Клик по плюсику - разворачиваем / сворачиваем    
    $tree.click(function(e) {
        $expander = $(e.target).filter(".expander");
        if($expander.length) {
            $node = node($expander);
            if(!$node.hasClass("expanded")) {
                $node.trigger("expand")
            } else {
                $node.trigger("collapse");
            }
        }
    });
    
    $tree.on("expand", function(event) {
        $node = node(event.target);
        $node.addClass("expanded");
        event.stopPropagation();
        $node.trigger("refresh");
    });
    
    $tree.on("collapse", function(event) {
        $node = node(event.target);
        $node.removeClass("expanded");
        event.stopPropagation();
    });
    
    $tree.on("refresh", function(event) {
        event.stopPropagation();
        $node = node(event.target);

        if(params.loader) {
            var loader = mod.deepCopy(params.loader);
            
            var data = {};
            var attr = $node.get(0).attributes;
            for(var i = 0; i < attr.length; i++) {
                if(attr[i].nodeName.match(/^data\:/)) {
                    loader[attr[i].name.replace(/^data\:/, "")] = attr[i].value;
                }
            }
            
            mod.call(loader, function(html) {
                $node.find(" > .subdivisions").html(html);
            });
        }
    });
};