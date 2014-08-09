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

    // Загружает список элементов и выводит их на страницу
    var load = function() {
    
        var collection = $container.attr("infuso:collection");
    
        var params = {
            cmd:"infuso/cms/reflex/controller/getItems",
            collection:collection
        };
        
        $container.find(" > .loader").show();
    
        mod.fire("reflex/beforeLoad",params);
        
        mod.call(params, function(ret) {
            $container.find(".ajax").html(ret.html);
            $container.find(" > .loader").hide();
        }, {
            unique: "ui7605fvbl"
        });
    }
    
    load();
    
    $container.on("reflex/refresh", load);
    
    $container.on("reflex/deselect", function() {
        $(this).list("deselect");
    });
    
    // Перезагрузка по F5
    $(document).on("keydown",function(e) {
        if(e.keyCode == 116 && !e.ctrlKey) {
            load();
            e.preventDefault();
        }
    });
    
    // Перетаскивание файлов в браузер
    $container.draghover().on({
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
        mod.call({
            cmd: "infuso/cms/reflex/controller/uploadCreate",
            collection: $container.attr("infuso:collection")
        }, load, {
            files: {
                file: file
            }
        });
        
    });

});