earb.Node.Pattern.View = class extends earb.Node.View {

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 6;
        params.height = 6;
        return params;        
    }          

    renderContent() {
    
        // Добавляем вход
        this.addOut({
            label: "Вход",
            left: 40,
            top: 10
        }); 
        
        var node = this.node;
    
    }   

}