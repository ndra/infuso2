earb.Node.Generator.View = class extends earb.Node.View {  

    defaultParams() {
    
        var params = super.defaultParams();
        params.width = 3;
        return params;
        
    }    
   
    renderContent() {  
    
        this.addIn({
            label: "Гейн",
            port: "gain",
            left: 10,
            top: 10
        }); 
        
        this.addIn({
            label: "Частота",
            port: "freq",
            left: 10,
            top: 35
        }); 
        
        // Добавляем выход
        this.addOut({
            left: 140,
            top: 20
        }); 
        
        var view = this;
        
        var storeFrequency = function() {
            view.node.params.frequency = $freq.val();
        }
        
        var storeShape = function() {
            view.node.params.shape = $shape.val();
            mod.msg($shape.val());
        }
        
        var $freq = $("<input>")
            .val(this.node.params.frequency)
            .css({
                width: 40,
                position: "absolute",
                left: 20,
                top: 10
            }).on("input", storeFrequency)
            .on("change", storeFrequency)
            .appendTo(this.$content());
            
        var $shape = $("<select >")
            .css({
                width: 50,
                position: "absolute",
                left: 65,
                top: 10
            }).change(storeShape)
            .appendTo(this.$content());
            
        $("<option value='sine' >sine</option>").appendTo($shape);
        $("<option value='square' >square</option>").appendTo($shape);
        $("<option value='sawtooth' >sawtooth</option>").appendTo($shape);
        
        $shape.val(this.node.params.shape);
            
    }

}
    
