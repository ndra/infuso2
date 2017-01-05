earb.Song.LinkManager = class {

    constructor(song) {
        this.song = song;
        this.__links = {};
        this.__src = {};
        this.__dest = {};
    }
    
    link(id) {
        return this.__links[id];
    }
    
    links() {
        return new earb.LinkList(this, Object.keys(this.__links));
    }

    add(params) {
    
        var link = new earb.Link(params);
        link.setSong(this.song);
        var id = link.id();
                
        if(this.__links[id]) {
            mod.msg("Link already exists");
            return false;
        }
        
        if(!link.src()) {
            mod.msg("Link src does not exists");
            return false;
        }
        
        if(!link.dest()) {
            mod.msg("Link dest does not exists");
            return false;
        }
        
        // Сохраняем массив
        
        this.__links[id] = link;
        
        // Индексы для поиска
        
        if(!this.__src[link.params.src]) {
            this.__src[link.params.src] = [];
        }
        this.__src[link.params.src].push(link.id());

        if(!this.__dest[link.params.dest]) {
            this.__dest[link.params.dest] = [];            
        }
        this.__dest[link.params.dest].push(link.id());
        
        link.createPhysical();
        var song = this;
        
        this.song.redrawLinks();
        
    }
    
    byNode(nodeId) {
    
        var ret = [];
        var used = {};
    
        var idList = this.__src[nodeId];
        if(idList) {
            for(var i in idList) {
                var id = idList[i];
                if(!used[id]) {
                    ret.push(id);
                    used[id] = true;
                }
            }
        }
        
        var idList = this.__dest[nodeId];
        if(idList) {
            for(var i in idList) {
                var id = idList[i];
                if(!used[id]) {
                    ret.push(id);
                    used[id] = true;
                }
            }
        }
                
        return new earb.LinkList(this, ret);
    
    }
    
    /**
     * Удаляет связь id
     **/
    remove(id) {
        var link = this.__links[id];
        if(!link) {
            mod.msg("Link " + id + " does not exists", 1);
            return;
        }
        
        link.srcConnector().disconnect(link.destConnector());
        
        var removeFromArray = function(arr) {
            var what, a = arguments, L = a.length, ax;
            while (L > 1 && arr.length) {
                what = a[--L];
                while ((ax= arr.indexOf(what)) !== -1) {
                    arr.splice(ax, 1);
                }
            }
            return arr;
        }
        
        delete(this.__links[id]);
        
        removeFromArray(this.__src[link.params.src], link.id());
        if(this.__src[link.params.src].length == 0) {
            delete this.__src[link.params.src];
        }
        
        removeFromArray(this.__dest[link.params.dest], link.id());
        if(this.__dest[link.params.dest].length == 0) {
            delete this.__dest[link.params.dest];
        }
        
        this.song.redrawLinks();
    }

}