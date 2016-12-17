earb.node.generator.view = function(params) {      
   
    this.init = function(params) {
        earb.node.generator.view.prototype.init.call(this, params);
    }
    
    this.renderContent = function() {
        // Добавляем вход
        this.addIn({
            left: 10,
            top: 20
        });   
        
        // Добавляем вход
        this.addOut({
            left: 40,
            top: 20
        }); 
        
        $("<input>").appendTo(this.$content());
    }
    
    this.init(params);

}

earb.node.generator.view.prototype = new earb.nodeView;
    
