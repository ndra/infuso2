earb.Node.Synthesizer.View = class extends earb.Node.View {  

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 8;
        params.height = 5;
        return params;        
    }    
   
    renderContent() { 
    
        this.addIn({
            label: "Цифровой вход",
            port: "midi",
            left: 10,
            top: 10
        }); 
        
        // Добавляем выход
        this.addOut({
            left: 140,
            top: 10
        }); 
    }

}
    
