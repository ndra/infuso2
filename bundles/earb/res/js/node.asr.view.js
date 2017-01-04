earb.Node.ASR.View = class extends earb.Node.View { 

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 100;
        params.height = 50;
        return params;        
    }       

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
        this.addOut({
            label: "Выход",
            left: 40,
            top: 10
        }); 
        

    
    }   

}