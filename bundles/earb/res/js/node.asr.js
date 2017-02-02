earb.Node.ASR = class extends earb.Node {

    constructor(params) {
    
        if(!params.handlers) {
            params.handlers = {};
        }
        
        params.handlers["param/attackGain"] = function(event) {
            event.value = event.value * 1 || 0.01;
        }
        
        params.handlers["param/attackDuration"] = function(event) {
            event.value = event.value * 1 || 0.01;
        }
        
        params.handlers["param/sustainDecay"] = function(event) {
            event.value = event.value * 1 || 0.01;
        }      
        
        params.handlers["param/releaseDuration"] = function(event) {
            event.value = event.value * 1 || 0.01;
        }   
        
        super(params);
        
        this.on("param/attackDuration", function(event) {
            mod.msg(event.value);
        });
        
        var ctx = earb.Song.context();        
        this.gain = ctx.createGain();
        this.gain.gain.value = 0;
        this.gain.gain.linearRampToValueAtTime(this.params.attackGain * 1, ctx.currentTime + this.params.attackDuration * 1);
        this.gain.gain.setTargetAtTime(0, ctx.currentTime + this.params.attackDuration * 1, this.params.sustainDecay * 1);
        
        this.releaseGain = ctx.createGain();
        this.releaseGain.gain.value = 1;
        this.gain.connect(this.releaseGain);
        
        this.on("midi/stop", function() {
            this.releaseGain.gain.linearRampToValueAtTime(0, ctx.currentTime + this.params.releaseDuration * 1);
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
        params.attackDuration = .01;
        params.attackGain = 1;
        params.sustainDecay = .9;
        params.releaseDuration = .5;
        return params;
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.releaseGain;
        }
    }
    
    inConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }

}

earb.registerNodeType(earb.Node.ASR, "Rc31FnpUq8fm");