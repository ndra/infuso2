mod.init(".mwf8wqyh3i", function() {
  
    var $container = $(this);
    var $toolbar = $(this).find(".toolbar");
        
    var createList = function() {
        $container.list({
            selechHandle: ".body"
        });
    }
    
    $container.on("updateList", function() {
        createList();    
    });
    
    createList();
    
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