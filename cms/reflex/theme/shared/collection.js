mod.init(".x2s6mdnq7sy", function() {

    var $container = $(this);

    // При изменении выделения в коллекции, передаем эту информацию тулбару
    $container.on("list/select",function(event) {
        $(this).find(".c-toolbar").triggerHandler(event);
    })
    
    $container.on("reflex/beforeLoad",function(event) {
        $(this).find(".c-toolbar").triggerHandler(event);
    })
    
    $container.on("reflex/refresh",function(e,params) {
        $(this).find(".c-items").triggerHandler("reflex/refresh");
    })
    
    $container.on("reflex/deselect",function(e,params) {
        $(this).find(".c-items").triggerHandler("reflex/deselect");
    })
    
    if($container.hasClass("layout")) {
        $(".x2s6mdnq7sy").layout();
    }
    
});