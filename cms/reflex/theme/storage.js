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
    
    // Перенаправляем события выделения в тулбар
    container.on("list/select", function(event) {
        container.find(".c-toolbar").triggerHandler(event);
    });
    
        
        // Клики по хлебным крошкам
        container.find(".back-path").click(function() {
            var path = $(this).attr("data:path");
            container.trigger({
                type: "reflex/storage/cd",
                path: path
            });
        });
        
        // Перетаскивание файлов в браузер
    
        container.on("dragover", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).addClass("drag-enter");
        });
        
        $(this).on("dragleave", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).removeClass("drag-enter");
        });
        
        $(this).on("drop", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).removeClass("drag-enter");
            var file = e.originalEvent.dataTransfer.files[0];            
            mod.call({
                cmd:"infuso/cms/reflex/controller/storage/upload",
                editor:editor,
                path:path
            }, load, {
                files: {
                    file: file
                }
            });
            
        });

});