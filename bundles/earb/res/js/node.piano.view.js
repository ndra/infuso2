earb.Node.Piano.View = class extends earb.Node.View {

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 440;
        params.height = 100;
        return params;        
    }          

    renderContent() {
    
        var view = this;
        
        // Добавляем выход
        this.addOut({
            label: "Цифровой выход",
            left: 10,
            top: 10
        }); 
        
        for(var i = 0; i < 10; i ++) {
            $("<div>")
                .data("n", i)
                .css({
                    left: i * 20 + 10,
                    top: 10,
                    width: 18,
                    height: 80,
                    position: "absolute",
                    background: "white"
                }).appendTo(this.$container)
                .mousedown(function() {
                    var $key = $(this);
                    view.handlePress($key.data("n"));                    
                    var fn = function() {
                        view.handleRelease($key.data("n"));
                        $(window).off("mouseup", fn);
                    };
                    $(window).mouseup(fn);
                });
        }
        
    } 
    
    handlePress(n) {
        this.node.sendMidiMessage({
            type: "play",
            note: n
        });
    }
    
    handleRelease(n) {
        this.node.sendMidiMessage({
            type: "stop",
            note: n
        });
    }  
    
}