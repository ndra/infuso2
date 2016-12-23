earb.Link = class extends earb.Base {

    constructor(params) {
        super(params);
    }
    
    setSong(song) {
        this.song = song;
    }
    
    storeKeys() {
        return ["src","srcPort","dest","destPort"];
    }
    
    src() {
        return this.song.node(this.params.src);
    }
    
    dest() {
        return this.song.node(this.params.dest);
    }
    
    id() {
        return this.params.src +":" + this.params.srcPort + ":" + this.params.dest + ":" + this.params.destPort;
    }
    
    srcConnector() {
        return this.src().outConnector(this.params.srcPort);
    }
    
    destConnector() {
        return this.dest().inConnector(this.params.destPort);
    }
    
    createPhysical() {
    
        var src = this.srcConnector();
        var dest = this.destConnector();
        
        if(!src) {
            mod.msg("Cannot create link: src connector not found " + this.src().constructor.nodeClassLabel(), 1);
            return;
        }
        
        if(!dest) {
            mod.msg("Cannot create link: dest connector not found " + this.dest().constructor.nodeClassLabel(), 1);
            return;
        }
        
        src.connect(dest);

    }
    
}

    
