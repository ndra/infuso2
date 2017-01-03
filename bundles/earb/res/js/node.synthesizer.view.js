earb.Node.Synthesizer.View = class extends earb.Node.View {  

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 8 * 50;
        params.height = 5 * 50;
        params.z = -1;
        return params;        
    }    
   
    renderContent() { 
    
        this.addIn({
            label: "Цифровой вход",
            port: "midi",
            left: 10,
            top: 10
        }); 
        
        var node = this.node;
        
        $("<div>")
            .css({
                left: 100,
                top: 100,
                width: 20,
                height: 20,
                background: "red",
                position: "absolute"
            }).appendTo(this.$container)
            .click(function() {
                node.playNote();
            });
 
    }

}
    
