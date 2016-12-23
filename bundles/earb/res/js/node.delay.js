earb.Node.Delay = class extends earb.Node {

    constructor(params) {
        super(params);

        var ctx = earb.Song.context();
        
        this.delay = ctx.createDelay(5);
        
        this.delay.delayTime.value = this.params.delay;
        
        this.on("param/delay", function(event) {
            this.delay.delayTime.value = event.value;
        });
        
    }

    viewConstructor() {
        return earb.Node.Delay.View;
    }

    static nodeClassLabel() {
        return "Дилэй";
    }
    
    storeKeys() {
        var keys = super.storeKeys();
        keys.push("delay");
        return keys;
    }
    
    defaultParams() {
        var params = super.defaultParams();
        params.delay = .5;
        return params;
    }
    
    inConnector(port) {
        if(port == "default") {
            return this.delay;
        }
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.delay;
        }
    }

}

earb.registerNodeType(earb.Node.Delay, "fHhTzpMYpx67");