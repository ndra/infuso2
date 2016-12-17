earb.node.noise.view = function(params) {      
   
    this.init = function(params) {
        earb.node.generator.view.prototype.init.call(this, params);
    }
    
    this.init(params);

}

earb.node.noise.view = new earb.nodeView;
    
