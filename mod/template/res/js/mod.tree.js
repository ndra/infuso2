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
        var theme = $node.attr("data:theme");
        var path = $node.attr("data:id");
        mod.call({
            cmd: "infuso/cms/bundlemanager/controller/theme/list",
            theme: theme,
            path: path
        }, function(html) {
            $node.find(" > .subdivisions").html(html);
        });
    });
};