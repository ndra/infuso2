earb.Node = class extends earb.Base {

    constructor(params) {
        super(params);
    }

    additionalStore() {
        if(this.view) {
            return {
                view: this.view.storeParams()
            };
        }
    }
    
    storeKeys() {
        return ["id","type"];
    }
    
    defaultParams() {
        return {
            id: mod.id()
        };
    }
    
    createView($container) {     
        var c = this.viewConstructor();
        this.view = new c(this.params.view);
        this.view.setNode(this); 
        this.view.render($container)     
    }
    
    viewConstructor() {
        return earb.Node.View;
    }
    
    outConnector(port) {
    }
    
    inConnector(port) {
    }
    
    isTemporary() {
        return !!this.params.temporary;
    }
    
    remove() {
        this.song.nodeManager.remove(this.params.id);
    }

}