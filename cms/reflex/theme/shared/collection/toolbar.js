mod.init(".qoi8w451jl", function() {

    var $container = $(this);

    // Изменение режима просмотра
    $container.find("select[name='viewMode']").change(function() {
        $(this).trigger("reflex/refresh");
    });
    
    // Быстрый поиск
    $container.find("input[name='query']").on("input", function() {
        $container.trigger("reflex/refresh");
    });
    
    $container.find(".refresh").click(function() {
        $container.trigger("reflex/refresh");
    });
    
    // Учет параметров фильтра перед загрузкой

    mod.on("reflex/beforeLoad",function(p) {    
        p.viewMode = $container.find("select[name='viewMode']").val();
        p.query = $container.find("input[name='query']").val();
    });
    
    // Создание элемента
    
    $container.find(".create").click(function() {
        var collection = $container.attr("infuso:collection");
        mod.call({
            cmd: "infuso/cms/reflex/controller/create",
            collection: collection
        }, function(url) {
            window.location.href = url;
        });
    });
    
    // реагируем на смену выделения    
    
    var sel = [];
    
    $container.on("list/select", function(e) {
        
        if(e.selection.length > 0) {
            $(this).find(".selection-info").html("Выбрано: " + e.selection.length);
        }
        
        var $container = $(this).find(".functions");
        var $hint = $(this).find(".hint");
        if(e.selection.length > 0) {
            $container.animate({opacity:1});
            $hint.animate({opacity:0});
        } else {
            $container.animate({opacity:0});
            $hint.animate({opacity:1});
        }
        sel = e.selection;
    });
    
    // Удаление

    $container.find(".delete").click(function() {
    
        if(!confirm("Удалить выбранные объекты")) {
            return;
        }
    
        mod.call({
            cmd: "infuso/cms/reflex/controller/delete",
            items: sel
        }, function() {
            $container.trigger("reflex/refresh");   
        });        
    });
    
    // Редактирование
    
    $container.find(".edit").click(function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/getEditUrls",
            items: sel
        }, function(editors) {
            
            if(editors.length == 1) {
                window.location.href = editors[0];
            } else {
                for(var i in editors) {
                    var win = window.open(editors[i]);
                }
            }
        }); 
    });
    
    // Просмотр
    
    $container.find(".view").click(function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/getViewUrls",
            items: sel
        }, function(editors) {
            
            if(editors.length == 1) {
                window.location.href = editors[0];
            } else {
                for(var i in editors) {
                    var win = window.open(editors[i]);
                }
            }
        }); 
    });
    
    $container.find(".deselect").click(function() {
        $container.trigger("reflex/deselect");
    });

});