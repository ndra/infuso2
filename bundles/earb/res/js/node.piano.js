earb.Node.Piano = class extends earb.Node {

    constructor(params) {
        super(params);  
        this.connected = []; 
    }   
    
    defaultParams() {    
        var params = super.defaultParams();
        return params;        
    }   
    
    storeKeys() {
        var keys = super.storeKeys();
        return keys;
    }
    
    viewConstructor() {
        return earb.Node.Piano.View;
    }

    static nodeClassLabel() {
        return "Клавиатура";
    }
    
    sendMidiMessage(msg) {    
        for(var i in this.connected) {
            this.connected[i].fire("midi", msg);
        }
    }
   
    /**
     * @todo сделать нормально disconnect
     **/
    outConnector(port) {
        if(port == "default") {
            var node = this;
            return new function() {
                this.connect = function(dest) {
                    node.connected.push(dest);
                }
                this.disconnect = function(dest) {
                    //node.connected.push(dest);
                }
            };
        }
    }

}

earb.registerNodeType(earb.Node.Piano, "exWzhlqg1Iyp");