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
        params.pattern = {};
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
        this.playNote(event.frequency);         
    }
    
    playNote(f) {
        this.song.nodeManager.nodes()
            .inside(this)
            .not(this.params.id)
            .clone({
                f: f,
                temporary: true
            });
    }
    
}

earb.registerNodeType(earb.Node.Synthesizer, "EXHkKOmZVBc2");