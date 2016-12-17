earb.node.noise = function(params) {

    this.init = function(params) {
        earb.node.generator.prototype.init.call(this, params);
    }

    this.init(params);
    
}

earb.node.noise.prototype = new earb.node();