earb.Node.View = class extends earb.Base {

    constructor(params) {
    
        super(params);
            
        this.on("param/x", function(event) {         
            event.value = Math.round(event.value) || 0;        
            if(!this.$container) {
                return;
            }              
            this.$container.css("left", event.value);
            this.node.song.fire("node/move");
        });
        this.on("param/y", function(event) {                  
            event.value = Math.round(event.value) || 0;          
            if(!this.$container) {
                return;
            }
            this.$container.css("top", event.value);
            this.node.song.fire("node/move");
        });
        
        this.on("param/z", function(event) {                  
            event.value = Math.round(event.value) || 0;          
            if(!this.$container) {
                return;
            }
            this.$container.css("z-index", event.value + 10);
        });
        
        this.on("param/width", function(event) {
            if(!this.$container) {
                return;
            }
            this.$container.css("width", event.value);
        });
        this.on("param/height", function(event) {
            if(!this.$container) {
                return;
            }
            this.$container.css("height", event.value);            
        }); 
        
        this.inElements = {};
        this.outElements = {};
               
    }
    
    remove() {
        this.$container.remove();
    }
    
    defaultParams() {
        return {
            width: 50,
            height: 50,
            x: 0,
            y: 0,
            z: 0
        };
    }
    
    setNode(node) {
        this.node = node;    
    }
    
    storeKeys() {
        return ["x","y"];
    }

    render($e) {
    
        var view = this;
    
        this.$container = $("<div>")
            .data("node-id", this.node.params.id)
            .css("position", "absolute")
            .css("z-index", this.params.z + 10)
            .appendTo($e);
            
        var $frame = $("<div>")            
            .css("position", "absolute")
            .css("background", "linear-gradient(160deg, #666,#444)")
            .css("box-shadow", "0 0 5px rgba(0,0,0,.4)")
            .css("box-sizing", "border-box")
            .css("border-left", "1px solid #888")
            .css("border-top", "1px solid #888")
            .css("border-bottom", "1px solid #222")
            .css("border-right", "1px solid #222")
            .css("border-radius", 3)
            .css("left", 1)
            .css("right", 1)
            .css("top", 1)
            .css("bottom", 1)
            .appendTo(this.$container);
            
        earb.dragndrop(this.$container, {
            dropClass: "drop-trash"
        });
        
        this.$container.on("mod/dragend", function(event) {
            view.params.x += event.dx;
            view.params.y += event.dy;
            view.params.x = Math.round(view.params.x / 10) * 10;
            view.params.y = Math.round(view.params.y / 10) * 10; 
        });
            
        // Переустанавливаем параметры, чтобы сработали обработчики
        // И нода перерисовалась
        this.params.width = this.params.width;
        this.params.height = this.params.height;
        this.params.x = this.params.x;
        this.params.y = this.params.y;      
        
        this.renderContent();

    };
    
    $content() {
        return this.$container;
    }
    
    renderContent() {
    }
   
    addIn(params) {
    
        params = earb.extend({
            left: 0,
            top: 0,
            label: "",
            port: "default"
        }, params);
    
        var $e = $("<div>")
            .css("position", "absolute")
            .css("left", params.left)
            .css("top", params.top)
            .appendTo(this.$container);
            
        var $circle = $("<div>")
            .addClass("g-socket")
            .addClass("drop-socket-in")
            .attr("title", params.label)
            .appendTo($e);
            
        $("<div>").appendTo($circle);
            
        var view = this;
            
        $circle.on("mod/drop", function(event) {
            var id = event.dragElement.data("out/id");
            view.node.song.createLink({
                src: id,
                srcPort: event.dragElement.data("out/port"),
                dest: view.node.params.id,
                destPort: params.port,
            });
        });
        
        this.inElements[params.port] = $circle;
    
    }
    
    getInElement(port) {
        return this.inElements[port];
    }
    
    /**
     * Добавляет выход
     **/
    addOut(params) {
    
        params = earb.extend({
            left: 0,
            top: 0,
            label: "",
            port: "default"
        }, params);
        
        var $e = $("<div>")
            .css("position", "absolute")
            .css("left", params.left)
            .css("top", params.top)
            .appendTo(this.$container);
            
        var $circle = $("<div>")
            .addClass("g-socket")
            .data("out/id", this.node.params.id)
            .data("out/port", params.port)
            .attr("title", params.label)
            .appendTo($e);
            
        $("<div>").appendTo($circle);
            
        earb.dragndrop($circle, {
            dropClass: "drop-socket-in"
        });
        
        this.outElements[params.port] = $circle;
        
    }
    
    getOutElement(port) {
        return this.outElements[port];
    }

}

    
