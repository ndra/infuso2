earb.Node.Synthesizer = class extends earb.Node {

    constructor(params) {
        super(params);          
        var ctx = earb.Song.context();        
        this.gain = ctx.createGain();    
        this.on("midi", this.handleMidi);  
        
        this.voices = {};   
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
        switch(event.type) {
            case "play":
                this.playNote(event.note);
                break;
            case "stop":
                this.stopNote(event.note)
                break;
        }         
    }
    
    playNote(note) {
    
        var f = earb.getNoteFrequency(note);
        
        var newNodes = this.song.nodeManager.nodes()
            .inside(this)
            .not(this.params.id)
            .clone({
                f: f,
                temporary: true
            });
            
        this.voices[note] = newNodes;            
    }
    
    stopNote(note) {
    
        var nodes = this.voices[note];
        if(!nodes) {
            return;
        }
        
        nodes.fire("midi/stop");
        
        setTimeout(function() {
            nodes.remove();
        }, 2000); 
        
        delete this.voices[note];
    
    }
    
}

earb.registerNodeType(earb.Node.Synthesizer, "EXHkKOmZVBc2");