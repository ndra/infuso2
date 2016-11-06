mod.init(".x2s6mdnq7sy", function() {

    var $container = $(this);

    // При изменении выделения в коллекции, передаем эту информацию тулбару
    $container.on("list/select",function(event) {
        $(this).find(".c-toolbar").triggerHandler(event);
    });
    
    $container.on("reflex/beforeLoad",function(event) {
        $(this).find(".c-toolbar").triggerHandler(event);
    });
    
    $container.on("reflex/refresh",function(e) {
        $(this).find(".c-items").triggerHandler("reflex/refresh");
    });
    
    $container.on("reflex/deselect",function(e) {
        $(this).find(".c-items").triggerHandler("reflex/deselect");
    });
    
    $container.on("reflex/options",function(e) {
        $(this).find(".c-items").triggerHandler("reflex/options");
    });
    
    if($container.hasClass("layout")) {
        $(".x2s6mdnq7sy").layout();
    }
    
});