earb.base = function() {

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
    
    this.init = function(inputParams) {
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
        
        this.params = inputParams;
    };
        
};