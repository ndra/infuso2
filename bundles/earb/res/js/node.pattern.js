earb.Node.Pattern = class extends earb.Node {

    constructor(params) {
        super(params);        
    }   
    
    viewConstructor() {
        return earb.Node.Pattern.View;
    }

    static nodeClassLabel() {
        return "Паттерн";
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }

}

earb.registerNodeType(earb.Node.Pattern, "9VH5TdGt6klj");