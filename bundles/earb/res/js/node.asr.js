earb.Node.ASR = class extends earb.Node {

    constructor(params) {
        super(params);

        var ctx = earb.Song.context();
        
        this.gain = ctx.createGain();
        //this.gain.gain.value = this.params.gain;
        
        this.on("param/gain", function(event) {
            this.gain.gain.value = event.value;
        });
        
    }

    viewConstructor() {
        return earb.Node.ASR.View;
    }

    static nodeClassLabel() {
        return "ASR";
    }
    
    storeKeys() {
        var keys = super.storeKeys();
        keys.push("attackDuration");
        keys.push("attackGain");
        keys.push("sustainDecay");
        keys.push("releaseDuration");
        return keys;
    }
    
    defaultParams() {
        var params = super.defaultParams();
        params.attack = .01;
        params.release = .01;
        return params;
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }

}

earb.registerNodeType(earb.Node.ASR, "Rc31FnpUq8fm");