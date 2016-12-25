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
    
}

earb.registerNodeType(earb.Node.Synthesizer, "EXHkKOmZVBc2");