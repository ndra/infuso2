earb.Song = class extends earb.Base {

    constructor(params) {
        super(params);
        this.nodes = [];
        if(this.params.nodes) {
            for(var i in this.params.nodes) {
                this.addNode(this.params.nodes[i]);
            }
        } 
    }
    
    defaultParams() {
        return {
            bpm: 120,
        };
    }
    
    storeKeys() {
        return ["bpm"];
    }
    
    additionalStore() {
        var ret = {
            nodes: []
        };
        for(var i in this.nodes) {
            ret.nodes.push(this.nodes[i].storeParams());
        }
        return ret;
    }
    
    addNode(params) {     
    
        var con = earb.getNodeConstructor(params.type);
        
        if(!con) {
            mod.msg("Failed create node " + params.type);
            return;
        }
        
        var node = new con(params);
        this.nodes.push(node);
        node.song = this;          
        setTimeout(function() {
            node.song.fire("addNode", node);
        });
        return node;
    }
    
}

    
