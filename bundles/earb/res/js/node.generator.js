earb.Node.Generator = class extends earb.Node {

    constructor(params) {
        super(params);
        
        var ctx = earb.Song.context();        
        this.oscillator = ctx.createOscillator();
        
        this.oscillator.type = this.params.shape;
        this.oscillator.frequency.value = this.params.frequency; // value in hertz
        this.oscillator.start();
        
        this.on("param/frequency", function(event) {
            this.oscillator.frequency.value = event.value;
        });
        
        this.on("param/shape", function(event) {
            this.oscillator.type = event.value;
        });
        
    }
    
    storeKeys() {
        var keys = super.storeKeys();
        keys.push("frequency");
        keys.push("shape");
        return keys;
    }
    
    defaultParams() {
        var params = super.defaultParams();
        params.frequency = 440;
        params.shape = "sine";
        return params;
    }
    
    viewConstructor() {
        return earb.Node.Generator.View;
    }
    
    static nodeClassLabel() {
        return "Генератор";
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.oscillator;
        }
    }
    
    inConnector(port) {
        if(port == "freq") {
            return this.oscillator.frequency;
        }
        if(port == "gain") {
            mod.msg(this.oscillator);
            return this.oscillator.gain;
        }
    }
    
}

earb.registerNodeType(earb.Node.Generator, "zkJXRd90mqLA");