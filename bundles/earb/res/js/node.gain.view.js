earb.Node.Gain.View = class extends earb.Node.View {      

    renderContent() {
    
        // Добавляем вход
        this.addIn({
            label: "Вход",
            left: 10,
            top: 20
        });   
        
        // Добавляем вход
        this.addOut({
            label: "Выход",
            left: 40,
            top: 20
        }); 
    
    }   

}