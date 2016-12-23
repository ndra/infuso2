earb.Node.View = class extends earb.Base {

    constructor(params) {
    
        super(params);
            
        this.on("param/x", function(event) {         
            event.value = Math.round(event.value) || 0;        
            if(!this.$container) {
                return;
            }              
            this.$container.css("left", event.value * 50);
            this.node.song.fire("node/move");
        });
        this.on("param/y", function(event) {                  
            event.value = Math.round(event.value) || 0;          
            if(!this.$container) {
                return;
            }
            this.$container.css("top", event.value * 50);
            this.node.song.fire("node/move");
        });
        this.on("param/width", function(event) {
            if(!this.$container) {
                return;
            }
            this.$container.css("width", event.value * 50);
        });
        this.on("param/height", function(event) {
            if(!this.$container) {
                return;
            }
            this.$container.css("height", event.value * 50);            
        }); 
        
        this.inElements = {};
        this.outElements = {};
               
    }
    
    defaultParams() {
        return {
            width: 1,
            height: 1
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
            .css("position", "absolute")
            .css("left", -5)
            .css("top", -5)
            .css("width", 10)
            .css("height", 10)
            .css("background", "green")
            .css("border-radius", 5)
            .attr("title", params.label)
            .appendTo($e);
            
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
            .css("position", "absolute")
            .css("left", -5)
            .css("top", -5)
            .css("width", 10)
            .css("height", 10)
            .css("background", "blue")
            .css("border-radius", 5)
            .data("out/id", this.node.params.id)
            .data("out/port", params.port)
            .attr("title", params.label)
            .appendTo($e);
            
        earb.dragndrop($circle);
        
        this.outElements[params.port] = $circle;
        
    }
    
    getOutElement(port) {
        return this.outElements[port];
    }

}

    
