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
 
    }

}
    
