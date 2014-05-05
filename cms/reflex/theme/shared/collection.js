$(function() {
    
    // При изменении выделения в коллекции, передаем эту информацию тулбару
    $(".x2s6mdnq7sy").on("list/select",function(event) {
        $(this).find(".c-toolbar").triggerHandler(event);
    })
    
    $(".x2s6mdnq7sy").on("reflex/refresh",function(e,params) {
        $(this).find(".c-items").triggerHandler("reflex/refresh");
    })

});