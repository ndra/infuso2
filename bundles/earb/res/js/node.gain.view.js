earb.Node.Gain.View = class extends earb.Node.View {      

    renderContent() {
    
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
    
        // Добавляем вход
        this.addIn({
            label: "Вход",
            left: 10,
            top: 10
        });
        
        // Добавляем вход
        this.addIn({
            label: "Гейн",
            left: 25,
            top: 40,
            port: "gain"
        });    
        
        // Добавляем вход
        this.addOut({
            label: "Выход",
            left: 40,
            top: 10
        }); 
        

    
    }   

}