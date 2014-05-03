$(function() {

    $(".x8gdq98zre1").mod("init", function() {
    
        var container = $(".x8gdq98zre1");
        var file = container.find("input[type=file]");
        var editor = container.attr("infuso:editor");
        var selection = [];
        var path = "/";
        
        // Когда пользолватель выбрал файл, закачиваем его
        
        file.change(function() {
            mod.call({
                cmd:"infuso/cms/reflex/controller/storage/upload",
                editor:editor,
                path:path
            },function() {
                container.trigger("reflex/storage/upload");
            },{
                files: container
            });
        });
        
        // Создание папки
        
        container.find(".createFolder").click(function() {
        
            var name = prompt("Укажите имя папки");
            if(name === null) {
                return;
            }
        
            mod.call({
                cmd:"infuso/cms/reflex/controller/storage/createFolder",
                editor:editor,
                name: name,
                path:path
            }, function() {
                container.trigger("reflex/storage/upload");
            });            
            
        });
        
        // Скачать
        
        container.find(".download").click(function() {
            for(var i in selection) {
                window.open(selection[i]);
            }
        });
        
        // Удалить
        
        container.find(".delete").click(function() {
            container.trigger("reflex/storage/upload");
        });
        
        container.on("list/select", function(e) {
            selection =  e.selection;
            if(e.selection.length) {
                container.find(".with-selection").fadeIn();
            } else {
                container.find(".with-selection").fadeOut();
            }
        });
        
        container.on("reflex/storage/cd", function(e) {
            path = e.path;
        });
        
    });

})