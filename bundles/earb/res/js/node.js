earb.node = function(params) {

    this.params = params;
    
    this.additionalStore = function() {
        return {
            view: this.view.storeParams()
        };
    }
    
    this.storeKeys = function() {
        return ["id"];
    }
    
    this.defaultParams = function() {
        return {
            id: mod.id()
        };
    }

    this.view = new earb.nodeView(this.params.view);
    this.view.setNode(this);
   
    /**
     * Подключает ноду к другой ноде
     **/
    this.connect = function(node, port) {
    };

}

earb.node.prototype = earb.storable;

earb.nodeView = function(params) {

    var $container;
    
    var node;
    
    this.defaultParams = function() {
        return {
            width: 3,
            height: 1
        };
    }
    
    this.setNode = function(p) {
        node = p;    
    }
    
    this.storeKeys = function() {
        return ["x","y"];
    }
    
    this.init = function() {
        this.on("param/x", function(x) {
            if(!$container) {
                return;
            }
            $container.css("left", x * 50);
        });
        this.on("param/y", function(y) {
            if(!$container) {
                return;
            }
            $container.css("top", y * 50);
        });
        this.on("param/width", function(width) {
            if(!$container) {
                return;
            }
            $container.css("width", width * 50);
        });
        this.on("param/height", function(height) {
            if(!$container) {
                return;
            }
            $container.css("height", height * 50);
        });
    }
    
    this.init();
    
    this.params = params;

    this.render = function($e) {
    
        $container = $("<div>")
            .html(node.params.id)
            .css("border", "1px solid #ededed")
            .css("position", "absolute")
            .appendTo($e);
            
        earb.dragndrop($container);
            
        // Переустанавливаем параметры, чтобы сработали обработчики
        // И нода перерисовалась
        this.params.width = this.params.width;
        this.params.height = this.params.height;
        this.params.x = this.params.x;
        this.params.y = this.params.y;
        
        // Добавляем вход
        this.addIn();          

    };
   
    this.addIn = function(params) {
    
        params = earb.extend({
            left: 0,
            top: 0,
            label: ""
        }, params);
    
        var $e = $("<div>")
            .css("position", "absolute")
            .css("left", params.left)
            .css("top", params.top)
            .appendTo($container);
            
        var $circle = $("<div>")
            .css("position", "absolute")
            .css("left", -5)
            .css("top", -5)
            .css("width", 10)
            .css("height", 10)
            .css("background", "blue")
            .css("border-radius", 5)
            .appendTo($e);
    
    }
    
    this.addOut = function() {
    }

}

earb.nodeView.prototype = earb.storable;
    
