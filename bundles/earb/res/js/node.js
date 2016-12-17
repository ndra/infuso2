earb.Node = class extends earb.Base {

    constructor(params) {
        super(params);
        this.createView();  
    }

    additionalStore() {
        return {
            view: this.view.storeParams()
        };
    }
    
    storeKeys() {
        return ["id","type"];
    }
    
    defaultParams() {
        return {
            id: mod.id()
        };
    }
    
    createView() {     
        var c = this.viewConstructor();
        this.view = new c(this.params.view);
        this.view.setNode(this);      
    }
    
    viewConstructor() {
        return earb.Node.View;
    }

}