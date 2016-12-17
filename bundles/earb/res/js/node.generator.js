earb.node.generator = function(params) {

    this.init = function(params) {
        earb.node.generator.prototype.init.call(this, params);
        this.view = new earb.node.generator.view(this.params.view);
        this.view.setNode(this);
    }

    this.init(params);
    
}

earb.node.generator.prototype = new earb.node();
earb.registerNodeType(earb.node.generator, "zkJXRd90mqLA");