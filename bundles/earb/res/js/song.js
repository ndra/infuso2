earb.song = function(params) {
    
    var song = this;   
    
    var nodes = [];

    this.audioContext = new window.AudioContext();
    
    this.defaultParams = function() {
        bpm: 120
    }
    
    this.storeKeys = function() {
        return ["bpm"];
    }
    
    this.additionalStore = function() {
        var ret = {
            nodes: []
        };
        for(var i in nodes) {
            ret.nodes.push(nodes[i].storeParams());
        }
        return ret;
    }
    
    this.addNode = function(params) {
        var node = new earb.node.generator(params);
        nodes.push(node);
        node.song = this;          
        setTimeout(function() {
            song.fire("addNode", node);
        });
        return node;
    }
    
    this.play = function() {
    }
    
    this.stop = function() {
    }
    
    this.init = function(params) {    
        earb.song.prototype.init.call(this, params);
        if(this.params.nodes) {
            for(var i in this.params.nodes) {
                this.addNode(this.params.nodes[i]);
            }
        }                                     
    }
    
    this.init(params);
    
}

earb.song.prototype = new earb.base;

    
