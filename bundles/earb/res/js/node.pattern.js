earb.Node.Pattern = class extends earb.Node {

    constructor(params) {
        super(params);  
        this.connected = [];      
    }   
    
    defaultParams() {    
        var params = super.defaultParams();
        params.pattern = [];
        return params;        
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