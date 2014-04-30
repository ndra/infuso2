$(function() {
    
    // При изменении выделения в коллекции, передаем эту информацию тулбару
    $(".x2s6mdnq7sy").on("list/select",function(e,params) {
        $(this).find(".c-toolbar").trigger("selectionChanged",[params.selection]);
    })
    
    $(".x2s6mdnq7sy").on("reflex/refresh",function(e,params) {
        $(this).find(".c-items").triggerHandler("reflex/refresh");
    })

});