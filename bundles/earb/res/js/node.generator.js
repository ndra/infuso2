earb.Node.Generator = class extends earb.Node {

    constructor(params) {
        super(params);
        
        var ctx = earb.Song.context();        
        var oscillator = ctx.createOscillator();
        
        oscillator.type = this.params.shape;
        oscillator.frequency.value = this.params.frequency; // value in hertz
        oscillator.start();
        
        this.on("param/frequency", function(event) {
            oscillator.frequency.value = event.value;
        });
        
        this.on("param/shape", function(event) {
            oscillator.type = event.value;
        });
        
        this.oscillator = oscillator;
        
        this.on("param/on", function(event) {
            if(event.value) {
               // oscillator.gain = 1;
            } else {
               // oscillator.gain = 0;
            }
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
    }
    
}

earb.registerNodeType(earb.Node.Generator, "zkJXRd90mqLA");