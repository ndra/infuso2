earb.Node.ASR = class extends earb.Node {

    constructor(params) {
        super(params);
        var ctx = earb.Song.context();        
        this.gain = ctx.createGain();
        this.gain.gain.value = 0;
        this.gain.gain.linearRampToValueAtTime(1, ctx.currentTime + .01);
        this.gain.gain.linearRampToValueAtTime(.8, ctx.currentTime + .1);
        this.gain.gain.linearRampToValueAtTime(0, ctx.currentTime + .16);
        
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
        params.attackDuration = .01;
        params.attackGain = 1;
        params.sustainDecay = .9;
        params.releaseDuration = .5;
        return params;
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }
    
    inConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }

}

earb.registerNodeType(earb.Node.ASR, "Rc31FnpUq8fm");