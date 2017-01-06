earb.Node.Pattern = class extends earb.Node {

    constructor(params) {
        super(params);  
        this.connected = []; 
        
        this.tick = 0;  
        
        var node = this;
        setInterval(function() {
            node.handleTick();
        }, 100);   
    }   
    
    defaultParams() {    
        var params = super.defaultParams();
        params.pattern = [];
        return params;        
    }   
    
    storeKeys() {
        var keys = super.storeKeys();
        keys.push("pattern");
        return keys;
    }
    
    viewConstructor() {
        return earb.Node.Pattern.View;
    }

    static nodeClassLabel() {
        return "Паттерн";
    }
    
    sendMidiMessage(msg) {    
        for(var i in this.connected) {
            this.connected[i].fire("midi", msg);
        }
    }
    
    handleTick() {
        var n = this.tick % 16;
        var col = this.params.pattern[n];
        if(col) {
            for(var i in col) {                
                if(col[i]) {                 
                    var step = 7 - i;                    
                    var note = earb.scales.minor().note(step);
                    var frequency = earb.getNoteFrequency(note);
                
                    this.sendMidiMessage({
                        type: "play",
                        frequency: frequency,
                        duration: 200
                    });
                
                }
            }
        }
        this.tick ++;
    }
    
    outConnector(port) {
        if(port == "default") {
            var node = this;
            return new function() {
                this.connect = function(dest) {
                    node.connected.push(dest);
                }
            };
        }
    }

}

earb.registerNodeType(earb.Node.Pattern, "9VH5TdGt6klj");