mod.init(".mwf8wqyh3i", function() {
  
    var $container = $(this);
    var $toolbar = $(this).find(".toolbar");
    
    $container.tree();
        
    $container.list({
        selechHandle: ".body"
    });
    
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
    
    $container.on("dblclick", function(event) {
        $node = node(event.target)
        $container.trigger({
            type: "bundlemanager/openTemplate",
            theme: $node.attr("data:theme"),
            template: $node.attr("data:id")
        });
    });

    
        // Добавление шаблона    
        
    $toolbar.find(".add").click(function() {
        
        var name = prompt("Введите название шаблона");
        if(!name) {
            return;
        }
        
        var selection = $container.list("selection");
        var theme = $container.attr("data:theme");
        
        mod.call({
            cmd: "infuso/cms/bundlemanager/controller/theme/addTemplate",
            theme: theme,
            parent: selection[0],
            name: name
        }, function(data) {
            $container.find(".node").each(function() {
                if($(this).attr("data:id") == data.refresh) {
                    $(this).trigger("expand");
                    $(this).trigger("refresh");
                }
            })
        });

    });
    
});