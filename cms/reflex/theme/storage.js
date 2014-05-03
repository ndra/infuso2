$(function() {

    var container = $(".x0jgagz44k7");    
    var editor = $(".x0jgagz44k7").attr("infuso:editor");  
    var path = "/";

    var load = function() {
             
        mod.call({
            cmd:"infuso/cms/reflex/controller/storage/getFiles",
            editor: editor,
            path: path
        },function(p) {
            container.find(".files").html(p.html);
        });
   
    }
    
    load();
    
    container.on("reflex/storage/upload",load);
    
    // Перенаправляем событие смены директории в тулбар
    container.on("reflex/storage/cd",function(event) {
        path = event.path;
        load();
        container.find(".c-toolbar").triggerHandler(event);
    });
    
    container.on("list/select", function(event) {
        container.find(".c-toolbar").triggerHandler(event);
    });

});