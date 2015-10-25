mod.init(".x0jgagz44k7", function() {

    var $container = $(this);    
    var editor = $container.attr("infuso:editor");  
    var path = "/";

    var load = function() {
             
        mod.call({
            cmd:"infuso/cms/reflex/controller/storage/getFiles",
            editor: editor,
            path: path
        },function(p) {
            $container.find(".files").html(p.html);
        });
   
    }
    
    load();
    
    $container.on("reflex/storage/upload",load);
    
    $container.layout();
    
    // Перенаправляем событие смены директории в тулбар
    $container.on("reflex/storage/cd",function(event) {
        path = event.path;
        load();
        $container.find(".c-toolbar").triggerHandler(event);
    });
    
    // Перенаправляем события выделения в тулбар
    $container.on("list/select", function(event) {
        $container.find(".c-toolbar").triggerHandler(event);
    });
    
    // Клики по хлебным крошкам
    $container.find(".back-path").click(function() {
        var path = $(this).attr("data:path");
        $container.trigger({
            type: "reflex/storage/cd",
            path: path
        });
    });
    
    var draghover = function($e) {
        $e.each(function() {
            
            var collection = $();
            var self = $(this);
    
            self.on('dragenter', function(e) {
                if (collection.length === 0) {
                    self.trigger('draghoverstart');
                }
                collection = collection.add(e.target);
            });
    
            self.on('dragleave drop', function(e) {
                collection = collection.not(e.target);
                if (collection.length === 0) {
                    self.trigger('draghoverend');
                }
            });
        });
    };
    
    // Перетаскивание файлов в браузер
    draghover($container);
    $container.on({
        'draghoverstart': function(event) {
            $(this).addClass("drag-enter");
        },
        'draghoverend': function(event) {
            $(this).removeClass("drag-enter");
        }
    });
    
    // Нужно сделать превент этому событию, иначе 
    // события drop не будет
    $container.on("dragover", function(e) {
        e.preventDefault();
    });
        
    $container.on("drop", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var file = e.originalEvent.dataTransfer.files[0];      
        var files = {};
        for(var i = 0; i < e.originalEvent.dataTransfer.files.length; i ++) {
            files["file" + i] = e.originalEvent.dataTransfer.files[i];
        }
        
        mod.call({
            cmd:"infuso/cms/reflex/controller/storage/upload",
            editor:editor,
            path:path
        }, load, {
            files:files
        });
    });

});