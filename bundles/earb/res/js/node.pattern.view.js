earb.Node.Pattern.View = class extends earb.Node.View {

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 8;
        params.height = 5;
        return params;        
    }          

    renderContent() {
    
        // Добавляем вход
        this.addOut({
            label: "Цифровой выход",
            left: 390,
            top: 220
        }); 
        
        var node = this.node;
        var view = this;
        
        this.$pad = $("<canvas>")
            .attr("width", this.$content().width())
            .attr("height", this.$content().height())
            .css({
                //border: "1px solid red"
            }).appendTo(this.$content())
            .mousedown(function(event) {
                var coords = view.getButtonFromCoords(event.offsetX, event.offsetY);
                view.handleButtonPress(coords);
            });
            
        this.renderPad();
        
    }   
    
    getButtonFromCoords(x,y) {
        return {
            col: Math.floor((x - this.padParams.margin) / (this.padParams.width + this.padParams.spacing)),
            row: Math.floor((y - this.padParams.margin) / (this.padParams.height + this.padParams.spacing)) 
        }
    }
    
    renderPad() {
    
        this.padParams = {
            margin: 1,
            spacing: 1,
            width: 24,
            height: 24,
            cols: 16,
            rows: 8
        }
    
        var ctx = this.$pad.get(0).getContext("2d");        
        ctx.fillStyle = "#ccc";     
        
        for(var j = 0; j < this.padParams.rows; j ++) {
            for(var i = 0; i < this.padParams.cols; i ++) {
                var x = this.padParams.margin + i * (this.padParams.width + this.padParams.spacing);
                var y = this.padParams.margin + j * (this.padParams.height + this.padParams.spacing); 
                ctx.fillRect(x, y, this.padParams.width, this.padParams.height);      
            }
        }
      
    }
    
    /**
     * Реакция на нажатие кнопки
     **/
    handleButtonPress(coords) {
    
        var frequency = earb.getNoteFrequency(coords.row);
    
        this.node.sendMidiMessage({
            type: "play",
            frequency: frequency,
            duration: 200
        });
    }

}