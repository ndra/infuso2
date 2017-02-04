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
        
        /**
         * Рисуем клавиатуру
         **/
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
        
        var codes = {
            49:0,
            50:1,
            51:2,
            52:3,
            53:4,
            54:5,
            55:6,
            56:7,
            57:8,
            48:9,
        };
        
        $(document).keydown(function(event) {
        
            if(event.originalEvent.repeat) {
                return;
            }
        
            var key = codes[event.keyCode];
            if(key != undefined) {
                view.handlePress(key);
            }
        });
        
        $(document).keyup(function(event) {
            var key = codes[event.keyCode];
            if(key != undefined) {
                view.handleRelease(key);
            }
        });
        
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