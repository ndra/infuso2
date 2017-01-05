earb.Song.NodeManager = class {

    constructor(song) {
        this.song = song;
        this.__nodes = {};
    }
    
    node(id) {
        return this.__nodes[id];
    }
    
    nodes() {
        return new earb.NodeList(this, Object.keys(this.__nodes));         
    }

    /**
     * Добавляет ноду
     **/
    add(params) {     
    
        var con = earb.getNodeConstructor(params.type);
        
        if(!con) {
            mod.msg("Failed create node " + params.type);
            return;
        }
        
        var node = new con(params);
        
        if(this.__nodes[node.params.id]) {
            mod.msg("node already exists", 1);
            return;
        }
        
        this.__nodes[node.params.id] = node;
        node.song = this.song;  
              
        setTimeout(function() {
            node.song.fire("node/render", node);
        });
       
        return node;
    }
    
    /**
     * Удаляет ноду
     **/
    remove(id) {
    
        var node = this.__nodes[id];   
         
        if(!node) {
            return;
        }
        
        // Удаляем вью
        if(node.view) {
            node.view.remove();
        }
        
        // Удаляем линки
        this.song.linkManager.byNode(id).remove();
        
        // Удаляем ноду из массива
        delete this.__nodes[id];
    }

}