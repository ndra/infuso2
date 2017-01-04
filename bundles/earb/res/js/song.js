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
    
    nodeList() {       
        var nodes = [];
        for(var id in this.nodes) {
            nodes.push(id);
        }
        return new earb.NodeList(this, nodes);
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
    
    /**
     * Удаляет ноду
     **/
    removeNode(id) {
        var node = this.nodes[id];
        node.view.remove();
        for(var i in this.links) {
            if(this.links[i].params.src == id || this.links[i].params.dest == id) {
                this.removeLink(i);
            }
        }
        delete this.nodes[id];
    }
    
    node(id) {
        return this.nodes[id];
    }
    
    createLink(params) {
    
        var link = new earb.Link(params);
        link.setSong(this);
        var id = link.id();
                
        if(this.links[id]) {
            mod.msg("Link already exists");
            return false;
        }
        
        if(!link.src()) {
            mod.msg("Link src not exists");
            return false;
        }
        
        if(!link.dest()) {
            mod.msg("Link dest not exists");
            return false;
        }
        
        this.links[id] = link;
        link.createPhysical();
        var song = this;
        
        setTimeout(function() {
            song.fire("link/create");
        });
    }
    
    link(id) {
        return this.links[id];
    }
    
    /**
     * Удаляет связь id
     **/
    removeLink(id) {
        var link = this.links[id];
        if(!link) {
            mod.msg("Link " + id + " not exists", 1);
            return;
        }
        
        link.srcConnector().disconnect(link.destConnector());
        delete(this.links[id]);
        this.fire("link/create");
    }
    
    static context() {
    
        if(!earb.Song.ctx) {
            earb.Song.ctx = new (window.AudioContext || window.webkitAudioContext)();
        }
        
        return earb.Song.ctx;
        
    }
    
}

    
