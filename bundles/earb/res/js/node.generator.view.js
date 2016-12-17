earb.Node.Generator.View = class extends earb.Node.View {      
   
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
            top: 30
        }); 
        
        // Добавляем выход
        this.addOut({
            left: 100,
            top: 20
        }); 
        
        $("<input>")
            .val(this.node.params.id)
            .appendTo(this.$content());
    }

}
    
