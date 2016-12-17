earb.node = function(params) {

    this.additionalStore = function() {
        return {
            view: this.view.storeParams()
        };
    }
    
    this.storeKeys = function() {
        return ["id"];
    }
    
    this.defaultParams = function() {
        return {
            id: mod.id()
        };
    }

    /**
     * Подключает ноду к другой ноде
     **/
    this.connect = function(node, port) {
    };
    
    this.init = function(params) {
        earb.node.prototype.init.call(this, params);
        this.view = new earb.nodeView(this.params.view);
        this.view.setNode(this);        
    }

}

earb.node.prototype = new earb.base;
