earb.Base = class {

    constructor(inputParams) {
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
                            var event = {value : value};
                            that.fire("param/" + prop, event);
                            params[prop] = event.value;
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
    }
      
    storeParams () {
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
    
    storeKeys() {
        return [];
    } 
    
    defaultParams() { 
        return {
            test: "xxxxx",
        };       
    }  
    
    additionalStore() {
        return {};
    }  
    
    on(name, fn) {
        if(!this._handlers) {
            this._handlers = {};
        }
        if(!this._handlers[name]) {
            this._handlers[name] = [];
        }
        this._handlers[name].push(fn);
    }
    
    fire(name, params) {
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