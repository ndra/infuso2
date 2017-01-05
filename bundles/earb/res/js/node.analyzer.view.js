earb.Node.Analyzer.View = class extends earb.Node.View {  

    defaultParams() {    
        var params = super.defaultParams();
        params.width = 200;
        params.height = 100;
        return params;        
    }    

    renderContent() {
    
        // Добавляем вход
        this.addIn({
            label: "Вход",
            left: 10,
            top: 50
        });
        
        this.$canvas = $("<canvas>")
            .attr("width", this.$content().width() - 30)
            .attr("height", this.$content().height() - 20)
            .css({
                position: "absolute",                
                left: 20,
                top: 10,
                border:"1px solid rgba(0,0,0,.2)"
            }).appendTo(this.$content()); 
            
        var view = this;
        
        var draw = function() {
            view.draw();
            requestAnimationFrame(draw);
        };
        
        draw();
    
    }
    
    draw() {
    
        var bufferLength = this.node.analyser.frequencyBinCount;
        var dataArray = new Uint8Array(bufferLength);  
        this.node.analyser.getByteTimeDomainData(dataArray);
 
        var ctx = this.$canvas.get(0).getContext("2d"); 
        
        this.node.analyser.getByteTimeDomainData(dataArray);
        
        var WIDTH = this.$canvas.get(0).width;
        var HEIGHT = this.$canvas.get(0).height;
        
        ctx.fillStyle = 'rgb(200, 200, 200)';
        ctx.fillRect(0, 0, WIDTH, HEIGHT);
        ctx.lineWidth = 1;
        ctx.strokeStyle = 'rgb(0, 0, 0)';

        ctx.beginPath();
        var sliceWidth = WIDTH * 1.0 / bufferLength;
        var x = 0;

        for(var i = 0; i < bufferLength; i++) {
           
            var v = dataArray[i] / 128.0;
            var y = v * HEIGHT / 2;
            
            if(i === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
            
            x += sliceWidth;
        }

        ctx.lineTo(WIDTH, HEIGHT/2);
        ctx.stroke();
  
    } 

}