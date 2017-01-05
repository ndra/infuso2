earb.Node.Analyzer = class extends earb.Node {

    constructor(params) {
        super(params);                        
        var ctx = earb.Song.context();  
        this.analyser = ctx.createAnalyser(); 
        this.analyser.fftSize = 2048;
    }   
    
    viewConstructor() {
        return earb.Node.Analyzer.View;
    }

    static nodeClassLabel() {
        return "Анализер";
    }
    
    inConnector(port) {
        if(port == "default") {
            return this.analyser;
        }
    }

}

earb.registerNodeType(earb.Node.Analyzer, "t760XZPiQ7dt");