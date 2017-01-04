earb.Node.Synthesizer = class extends earb.Node {

    constructor(params) {
        super(params);          
        var ctx = earb.Song.context();        
        this.gain = ctx.createGain();    
        this.on("midi", this.handleMidi);     
    }
    
    storeKeys() {
        var keys = super.storeKeys();
        return keys;
    }
    
    defaultParams() {
        var params = super.defaultParams();
        return params;
    }
    
    viewConstructor() {
        return earb.Node.Synthesizer.View;
    }
    
    static nodeClassLabel() {
        return "Синтезатор";
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }
    
    inConnector(port) {
        if(port == "midi") {
            return this;
        }
    }
    
    handleMidi(event) {
        
        var ctx = earb.Song.context();   
        var oscillator = ctx.createOscillator();          
        oscillator.type = "sine";
        oscillator.frequency.value = event.frequency;
        oscillator.start();  
        oscillator.connect(this.gain);
        setTimeout(function() {
            oscillator.disconnect();        
        }, event.duration);
        
    }
    
    playNote() {
    
    
        /*for(var i in this.song.nodes) {
            var node = this.song.nodes[i];
            var view = this.song.nodes[i].view;
            if(view) {
                if(node.params.id != this.params.id
                    && node.view.params.x >= this.view.params.x
                    && node.view.params.y >= this.view.params.y
                    && node.view.params.x + node.view.params.width <= this.view.params.x + this.view.params.width
                    && node.view.params.y + node.view.params.height <= this.view.params.y + this.view.params.height) {
                    mod.msg(node.params.id);
                }
            }
        } */
    
        this.song.nodeList().inside(this).not(this.params.id).each(function() {
            mod.msg(this.params.id);
        });

    }
    
}

earb.registerNodeType(earb.Node.Synthesizer, "EXHkKOmZVBc2");