earb.Node.Pedal.View = class extends earb.Node.View {      

    renderContent() {
    
        // Добавляем вход
        this.addOut({
            label: "Вход",
            left: 40,
            top: 10
        }); 
        
        var node = this.node;
        
        this.$content().css({
            background: "#ededed"
        }).mousedown(function() {
            $(this).css("background", "#ccc");
            node.press();
        }).mouseup(function() {
            $(this).css("background", "#ededed");
            node.release();
        });  
        
    
    }   

}