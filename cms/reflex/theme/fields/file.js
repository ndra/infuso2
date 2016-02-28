mod.init(".l83i1tvf0u", function() {

    var $dropzone = $(this);
	var container = $(".l83i1tvf0u"); 
    var path = "/";
    
    var updatePreview = function() {
        mod.call({
            cmd:"infuso/cms/reflex/controller/storage/getPreview",
            editor: $dropzone.attr("data:editor"),
            value: $dropzone.find("input").val(),
            field: $dropzone.find("input").attr("name"),
        }, function(data) {
            $dropzone.find(".ajax-container").html(data);
        });
    };
    
    // Это для отладки оставлю
    // updatePreview();

    // Перетаскивание файла в дропзону

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
    draghover($dropzone);
    $dropzone.on({
        'draghoverstart': function(event) {
            $(this).addClass("drag-enter");
        },
        'draghoverend': function(event) {
            $(this).removeClass("drag-enter");
        }
    });
    
    // Нужно сделать превент этому событию, иначе 
    // события drop не будет
    $dropzone.on("dragover", function(e) {
        e.preventDefault();
    });
    
    $dropzone.on("drop", function(e) {
       e.stopPropagation();
       e.preventDefault();
	   
	   $(this).removeClass("drag-enter");
       var file = e.originalEvent.dataTransfer.files[0];  	
       mod.call({
            cmd:"infuso/cms/reflex/controller/storage/upload",
            editor: $dropzone.attr("data:editor"),
            path: path,
        }, function(data) {
            if(data) {
                $dropzone.find("input").val(data.filename);
                updatePreview();
            }
        }, {
            files: {
                file: file
            },
        });
    });
    
    // Окно выбора файлов
    $dropzone.on("filebrowser", function() {
        
        var $wnd = $.window({
            width:800,
            height: 500,
            title: "Выберите файл",
            call: {
                cmd:"infuso/cms/reflex/controller/storage/getWindow",
                editor: $dropzone.attr("data:editor")
            }
        });
        
        $wnd.on("reflex/storage/file", function(event) {
            $wnd.window("close");
            $dropzone.find("input").val(event.filename);
            updatePreview();
        });
        
    });

});