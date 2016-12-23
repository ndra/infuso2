earb.Node.Gain.View = class extends earb.Node.View {      

    renderContent() {
    
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
        
        var view = this;
        
        var storeGain = function() {
            view.node.params.gain = $gain.val();
        }
        
        var $gain = $("<input>")
            .val(this.node.params.gain)
            .css({
                width: 35,
                position: "absolute",
                left: 5,
                top: 20
            }).on("input", storeGain)
            .on("change", storeGain)
            .appendTo(this.$content());
    
    }   

}