earb.storable = new function() {

    this.storeParams = function() {
        var keys = this.storeKeys();
        var ret = {};
        for(var i in keys) {
            ret[keys[i]] = this.params[keys[i]];
        }   
        
        var add = this.additionalStore();
        for(var i in add) {
            ret[i] = add[i];
        }
             
        return ret;
    } 
    
    this.storeKeys = function() {
        return [];
    } 
    
    this.defaultParams = function() { 
        return {};       
    }  
    
    this.additionalStore = function() {
        return {};
    }  
    
    this.onParamChanged = function(name, value) {
    }
    
    Object.defineProperty(this, "params", {      
        get: function() {
            if(!this._paramsManager) {
                this._params = {};
                var params = this._params;
                var that = this;
                this._paramsManager = new Proxy({}, {
                    get: function(target, prop, receiver) {
                        return params[prop];
                    }, set: function(target, prop, value, receiver) {
                        params[prop] = value;
                        that.fire("param/" + prop, value);
                        return true;
                    }
                });
                
                var defaultParams = this.defaultParams();
                for(var i in defaultParams) {
                    this._paramsManager[i] = defaultParams[i];    
                }
                
            }
            return this._paramsManager;
        }, set: function(params) {
            for(var i in params) {
                this.params[i] = params[i];
            }
        }
    });
    
    this.on = function(name, fn) {
        if(!this._handlers) {
            this._handlers = {};
        }
        if(!this._handlers[name]) {
            this._handlers[name] = [];
        }
        this._handlers[name].push(fn);
    }
    
    this.fire = function(name, params) {
        if(!this._handlers) {
            return;
        }
        if(!this._handlers[name]) {
            return;
        }
        for(var i in this._handlers[name]) {
            this._handlers[name][i].call(this, params);
        }
    }
    
};

earb.song = function(params) {

    console.log(params);
    
    this.params = params;
    
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
        var node = new earb.node(params);
        nodes.push(node);
        node.song = song;          
        setTimeout(function() {
            song.fire("addNode", node);
        });
        return node;
    }
    
    this.play = function() {
    }
    
    this.stop = function() {
    }
    
    this.init = function() {
        if(this.params.nodes) {
            for(var i in this.params.nodes) {
                this.addNode(this.params.nodes[i]);
            }
        }
    }
    
    this.init();
    
}

earb.song.prototype = earb.storable;

    
