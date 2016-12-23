earb.Song = class extends earb.Base {

    constructor(params) {
        super(params);
        this.nodes = {};
        this.links = [];
        if(this.params.nodes) {
            for(var i in this.params.nodes) {
                this.addNode(this.params.nodes[i]);
            }
        } 
        if(this.params.links) {
            for(var i in this.params.links) {
                this.createLink(this.params.links[i]);
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
            nodes: [],
            links: []
        };
        for(var i in this.nodes) {
            ret.nodes.push(this.nodes[i].storeParams());
        }
        for(var i in this.links) {
            ret.links.push(this.links[i].storeParams());
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
        this.nodes[node.params.id] = node;
        node.song = this;    
              
        setTimeout(function() {
            node.song.fire("addNode", node);
        });
        return node;
    }
    
    node(id) {
        return this.nodes[id];
    }
    
    createLink(params) {
    
        var link = new earb.Link(params);
        var id = link.id();
                
        if(this.links[id]) {
            mod.msg("Link already exists");
            return false;
        }
        
        this.links[id] = link;
        link.setSong(this);
        link.createPhysical();
        var song = this;
        
        setTimeout(function() {
            song.fire("link/create");
        });
    }
    
    static context() {
    
        if(!earb.Song.ctx) {
            earb.Song.ctx = new (window.AudioContext || window.webkitAudioContext)();
        }
        
        return earb.Song.ctx;
        
    }
    
}

    
