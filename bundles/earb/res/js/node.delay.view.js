earb.Node.Delay.View = class extends earb.Node.View {      

    renderContent() {
    
        var view = this;
        
        this.$content().css("background", "rgba(0,0,255,.1)");
        
        var storeDelay = function() {
            view.node.params.delay = $delay.val();
        }
        
        var $delay = $("<input>")
            .val(this.node.params.delay)
            .css({
                width: 35,
                position: "absolute",
                left: 5,
                top: 20
            }).on("input", storeDelay)
            .on("change", storeDelay)
            .appendTo(this.$content());
    
        // Добавляем вход
        this.addIn({
            label: "Вход",
            left: 10,
            top: 10
        });
        
        // Добавляем вход
        this.addOut({
            label: "Выход",
            left: 40,
            top: 10
        }); 
        

    
    }   

}