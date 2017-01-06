earb.Node.Pattern.View = class extends earb.Node.View {

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 440;
        params.height = 5 * 50;
        return params;        
    }          

    renderContent() {
    
        this.padParams = {
            margin: 1,
            spacing: 2,
            width: 24,
            height: 24,
            cols: 16,
            rows: 8
        }
    
        // Добавляем вход
        this.addOut({
            label: "Цифровой выход",
            left: 10,
            top: 10
        }); 
        
        var node = this.node;
        var view = this;
        
        this.$pad = $("<canvas>")
            .attr("width", this.padParams.width * this.padParams.cols + this.padParams.spacing * (this.padParams.cols - 1))
            .attr("height", this.padParams.height * this.padParams.rows + this.padParams.spacing * (this.padParams.rows - 1))
            .css({
                position: "absolute",                
                left: 20,
                top: 20
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
    
        this.ctx = this.$pad.get(0).getContext("2d");        
        
        for(var j = 0; j < this.padParams.rows; j ++) {
            for(var i = 0; i < this.padParams.cols; i ++) {
                this.updateButton(i, j);     
            }
        }
      
    }
    
    updateButton(x, y) {
    
        
        var xx = this.padParams.margin + x * (this.padParams.width + this.padParams.spacing);
        var yy = this.padParams.margin + y * (this.padParams.height + this.padParams.spacing);
        
        this.ctx.clearRect(xx, yy, this.padParams.width, this.padParams.height);
        
        if(this.node.params.pattern[x] && this.node.params.pattern[x][y]) {
            this.ctx.fillStyle = "rgba(128, 255, 128, 1)";
        } else {
            this.ctx.fillStyle = "rgba(255, 255, 255, .2)";
        }
         
        this.ctx.fillRect(xx, yy, this.padParams.width, this.padParams.height);
                
    }
    
    /**
     * Реакция на нажатие кнопки
     **/
    handleButtonPress(coords) {
    
        if(!this.node.params.pattern[coords.col]) {
            this.node.params.pattern[coords.col] = {};
        } 
        this.node.params.pattern[coords.col][coords.row] = !this.node.params.pattern[coords.col][coords.row];           
        this.updateButton(coords.col, coords.row);
    }

}