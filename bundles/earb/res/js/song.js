earb.Song = class extends earb.Base {

    constructor(params) {
    
        super(params);
        
        this.nodeManager = new earb.Song.NodeManager(this);
        this.linkManager = new earb.Song.LinkManager(this);
        
        if(this.params.nodes) {
            for(var i in this.params.nodes) {
                this.nodeManager.add(this.params.nodes[i]);
            }
        }
         
        if(this.params.links) {
            for(var i in this.params.links) {
                this.linkManager.add(this.params.links[i]);
            }
        } 
    }
    
    /**
     * Ставит задачу на перерисовку линков
     **/
    redrawLinks() {
        if(!this.__redrawLinks) {
            var song = this;
            this.__redrawLinks = function() {
                song.fire("link/redraw");
            }
        }
        mod.delay(this.__redrawLinks, 50);
    }
    
  
    defaultParams() {
        return {
            bpm: 120,
        };
    }
    
    storeKeys() {
        return ["bpm"];
    }
    
    /**
     * Возвращает дополнительные параметры для сохранения
     **/
    additionalStore() {
        var ret = {
            nodes: [],
            links: []
        };
        
        this.nodeManager.nodes().each(function() {
            if(!this.isTemporary()) {
                ret.nodes.push(this.storeParams());
            }
        });
        
        this.linkManager.links().each(function() {
            if(this.src().isTemporary()) {
                return;
            }
            if(this.dest().isTemporary()) {
                return;
            }
            ret.links.push(this.storeParams());
        });
        
        return ret;
    }
    
    static context() {
    
        if(!earb.Song.ctx) {
            earb.Song.ctx = new (window.AudioContext || window.webkitAudioContext)();
        }
        
        return earb.Song.ctx;
        
    }
    
}

    
