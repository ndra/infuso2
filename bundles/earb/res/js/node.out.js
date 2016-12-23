earb.Node.Out = class extends earb.Node {

    constructor(params) {
        super(params);
    }   

    viewConstructor() {
        return earb.Node.Out.View;
    }

    static nodeClassLabel() {
        return "Выход";
    }
    
    inConnector(port) {
        if(port == "default") {
            return earb.Song.context().destination;
        }
    }

}

earb.registerNodeType(earb.Node.Out, "9swDOUhsithV");