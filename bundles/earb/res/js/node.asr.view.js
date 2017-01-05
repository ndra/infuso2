earb.Node.ASR.View = class extends earb.Node.View { 

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 160;
        params.height = 30;
        return params;        
    }       

    renderContent() {
    
        var view = this;
        
        var storeAttackDuration = function() {
            view.node.params.attackDuration = $attackDuration.val();
        }
        
        var $attackDuration = $("<input>")
            .val(this.node.params.attackDuration)
            .css({
                width: 25,
                position: "absolute",
                left: 20,
                top: 7
            }).on("input", storeAttackDuration)
            .on("change", storeAttackDuration)
            .appendTo(this.$content()); 
            
        var storeAttackGain = function() {
            view.node.params.attackGain = $attackGain.val();
        }
            
        var $attackGain = $("<input>")
            .val(this.node.params.attackGain)
            .css({
                width: 25,
                position: "absolute",
                left: 50,
                top: 7
            }).on("input", storeAttackGain)
            .on("change", storeAttackGain)
            .appendTo(this.$content()); 
            
        var storeSustainDecay = function() {
            view.node.params.sustainDecay = $sustainDecay.val();
        }
            
        var $sustainDecay = $("<input>")
            .val(this.node.params.sustainDecay)
            .css({
                width: 25,
                position: "absolute",
                left: 80,
                top: 7
            }).on("input", storeSustainDecay)
            .on("change", storeSustainDecay)
            .appendTo(this.$content()); 
            
        var storeReleaseDuration = function() {
            view.node.params.releaseDuration = $releaseDuration.val();
        }
            
        var $releaseDuration = $("<input>")
            .val(this.node.params.releaseDuration)
            .css({
                width: 25,
                position: "absolute",
                left: 110,
                top: 7
            }).on("input", storeReleaseDuration)
            .on("change", storeReleaseDuration)
            .appendTo(this.$content()); 
            
        // Добавляем вход
        this.addIn({
            label: "Вход",
            left: 10,
            top: 15 
        }); 
        
        // Добавляем вход
        this.addOut({
            label: "Выход",
            left: 145,
            top: 15
        });
            
    }   

}