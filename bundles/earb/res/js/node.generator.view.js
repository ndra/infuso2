earb.Node.Generator.View = class extends earb.Node.View {      
   
    renderContent() {
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

}
    
