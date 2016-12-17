earb.nodeView = function(params) {
    
    this.defaultParams = function() {
        return {
            width: 3,
            height: 1
        };
    }
    
    this.setNode = function(p) {
        this.node = p;    
    }
    
    this.storeKeys = function() {
        return ["x","y"];
    }

    this.render = function($e) {
    
        var view = this;
    
        this.$container = $("<div>")
            .html(this.node.params.id)
            .css("border", "1px solid #ededed")
            .css("box-sizing", "border-box")
            .css("position", "absolute")
            .appendTo($e);
            
        earb.dragndrop(this.$container);
        
        this.$container.on("mod/dragend", function(event) {
            view.params.x += Math.round(event.dx / 50);
            view.params.y += Math.round(event.dy / 50);
        });
            
        // Переустанавливаем параметры, чтобы сработали обработчики
        // И нода перерисовалась
        this.params.width = this.params.width;
        this.params.height = this.params.height;
        this.params.x = this.params.x;
        this.params.y = this.params.y;
        
        // Добавляем вход
        this.addIn({
            left: 10,
            top: 20
        });   
        
        // Добавляем вход
        this.addOut({
            left: 40,
            top: 20
        });       

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
            .appendTo(this.$container);
            
        var $circle = $("<div>")
            .css("position", "absolute")
            .css("left", -5)
            .css("top", -5)
            .css("width", 10)
            .css("height", 10)
            .css("background", "green")
            .css("border-radius", 5)
            .appendTo($e);
            
        $circle.on("mod/drop", function(event) {
            var id = event.dragElement.data("out/id");
            this.node.connectTo(id);
        });
    
    }
    
    this.addOut = function(params) {
    
        params = earb.extend({
            left: 0,
            top: 0,
            label: ""
        }, params);
        
        var $e = $("<div>")
            .css("position", "absolute")
            .css("left", params.left)
            .css("top", params.top)
            .appendTo(this.$container);
            
        var $circle = $("<div>")
            .css("position", "absolute")
            .css("left", -5)
            .css("top", -5)
            .css("width", 10)
            .css("height", 10)
            .css("background", "blue")
            .css("border-radius", 5)
            .data("out/id", this.node.params.id)
            .appendTo($e);
            
        earb.dragndrop($circle);
        
    }
    
    this.init = function(params) {
    
        earb.nodeView.prototype.init.call(this, params);
    
        this.on("param/x", function(x) {
            if(!this.$container) {
                return;
            }
            this.$container.css("left", x * 50);
        });
        this.on("param/y", function(y) {
            if(!this.$container) {
                return;
            }
            this.$container.css("top", y * 50);
        });
        this.on("param/width", function(width) {
            if(!this.$container) {
                return;
            }
            this.$container.css("width", width * 50);
        });
        this.on("param/height", function(height) {
            if(!this.$container) {
                return;
            }
            this.$container.css("height", height * 50);
        }); 
               
    }
    
    this.init(params);

}

earb.nodeView.prototype = new earb.base;
    
