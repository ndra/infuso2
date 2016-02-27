// The plugin code
$.fn.draghover = function(options) {
    return this.each(function() {
        
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

mod.init(".cjoesz8swu", function() {

    var $container = $(this);
    
    var filter = 0;
    
    var page = 1;

    // Загружает список элементов и выводит их на страницу
    var load = function() {
    
        var collection = $container.attr("infuso:collection");
    
        var params = {
            cmd:"infuso/cms/reflex/controller/getItems",
            collection:collection,
            filter: filter,
            page: page
        };
        
        $container.find(" > .loader").show();
    
        //mod.fire("reflex/beforeLoad", params);
        
        $container.trigger({
            type: "reflex/beforeLoad",
            params: params
        });
        
        mod.call(params, function(ret) {
            $container.find(".ajax").html(ret.html);
            $container.find(" > .loader").hide();
        }, {
            unique: "ui7605fvbl"
        });
    }
    
    $container.on("reflex/refresh", load);
    
    $container.on("reflex/beforeSavePriority", function(event) {
        event.params.page = page;
        event.params.filter = filter;
    });
    
    $container.on("reflex/setPage", function(event) {
        page = event.page;
        load();
    });
    
    $container.on("reflex/deselect", function() {
        $(this).list("deselect");
    });
    
    $container.on("reflex/setFilter", function(event) {
        filter = event.filter;
        load();
    });
    
    // Перезагрузка по F5
    $(document).on("keydown",function(e) {
        if(e.keyCode == 116 && !e.ctrlKey) {
            load();
            e.preventDefault();
        }
    });
    
    var dropFiles = true;
    var sortProcessing = false;
    
    mod.on("reflex/sort-begin", function() {
        sortProcessing = true;
    });
    
    mod.on("reflex/sort-end", function() {
        sortProcessing = false;
    });
    
    if(dropFiles) {
    
        // Перетаскивание файлов в браузер
        $container.draghover().on({
            'draghoverstart': function(event) {
                if(!sortProcessing) {
                    $(this).addClass("drag-enter");
                }
            },
            'draghoverend': function(event) {
                if(!sortProcessing) {
                    $(this).removeClass("drag-enter");
                }
            }
        });
        
        // Нужно сделать превент этому событию, иначе 
        // события drop не будет
        $container.on("dragover", function(e) {
            if(!sortProcessing) {
                e.preventDefault();
            }
        });
        
        $container.on("drop", function(e) {
            if(!sortProcessing) { 
                e.stopPropagation();
                e.preventDefault();
                var files = e.originalEvent.dataTransfer.files;
                if(files.length) {
                    mod.call({
                        cmd: "infuso/cms/reflex/controller/uploadCreate",
                        collection: $container.attr("infuso:collection")
                    }, load, {
                        files: files
                    });
                }
            }
        });
    
    }

});