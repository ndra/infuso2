earb.Node.Gain = class extends earb.Node {

    constructor(params) {
        super(params);

        var ctx = earb.Song.context();
        
        this.gain = ctx.createGain();
        this.gain.gain.value = this.params.gain;
        
        this.on("param/gain", function(event) {
            this.gain.gain.value = event.value;
        });
        
    }

    viewConstructor() {
        return earb.Node.Gain.View;
    }

    static nodeClassLabel() {
        return "Гейн";
    }
    
    storeKeys() {
        var keys = super.storeKeys();
        keys.push("gain");
        return keys;
    }
    
    defaultParams() {
        var params = super.defaultParams();
        params.gain = 1;
        return params;
    }
    
    inConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }

}

earb.registerNodeType(earb.Node.Gain, "skfHSI9QRBbv");