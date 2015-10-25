mod.init(".getcbtu0lh", function() {
    
    var $container = $(this);
    
    $container.layout();

    // Клик на файл
    $container.find(".list-item").not(".folder").click(function() {
        // Клик на выбиралку пропускаем
        if($(event.target).is(".select-handle")) {
            return;
        }
        $(this).trigger({
            type: "reflex/storage/file",
            filename: $(this).attr("data:filename"),
            preview150: $(this).attr("data:preview150")
        });
    });
    
    // При клике на папку, меняем текущуюу папку
    // Если мы кликнули на выбиралку, папку не меняем
    $container.find(".folder").click(function(event) { 
    
        // Клик на выбиралку пропускаем
        if($(event.target).is(".select-handle")) {
            return;
        }
         
        // Меняем папку  
        var path = $(this).attr("data:id");
        $container.trigger({
            type: "reflex/storage/cd",
            path: path
        });
    });
    
    $container.list({
        selectHandle: ".select-handle",
        easyMultiselect: true
    });
    
    $container.on("list/select", function(event) {
        var selected = $container.find(".list-item.selected").not(".folder").eq(0);
        event.filename = selected.attr("data:filename");
        event.preview150 = selected.attr("data:preview150");
    });

});