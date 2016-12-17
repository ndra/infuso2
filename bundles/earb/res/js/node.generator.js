earb.node.generator = function(params) {

    this.init = function(params) {
        earb.node.generator.prototype.init.call(this, params);
    }

    this.init(params);
    
}

earb.node.generator.prototype = new earb.node();