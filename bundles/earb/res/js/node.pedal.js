earb.Node.Pedal = class extends earb.Node {

    constructor(params) {
        super(params);
        
        var ctx = earb.Song.context();  
        
        this.gain = ctx.createGain();
        this.gain.gain.value = 1;  
        
        // Создаем источник постоянного тока  
        
        var node = ctx.createBufferSource();
        var buffer = ctx.createBuffer(1, 1, ctx.sampleRate);
        var data = buffer.getChannelData(0);
        for (var i = 0; i < 1; i++) {
            data[i] = 1;
        }
        
        node.buffer = buffer;
        node.loop = true;
        node.connect(this.gain);
        node.start(0);
        
    }   
    
    press() {
        this.gain.gain.value = 1;
    }
    
    release() {
        this.gain.gain.value = 0;
    }

    viewConstructor() {
        return earb.Node.Pedal.View;
    }

    static nodeClassLabel() {
        return "Педаль";
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }

}

earb.registerNodeType(earb.Node.Pedal, "oKBHE5bA31zm");