earb.NodeList = class {

    constructor(nodeManager, idList) {
        this.nodeManager = nodeManager;
        this.idList = idList;
    }
    
    each(fn) {
        for (var i in this.idList) {
            var node = this.nodeManager.node(this.idList[i]);
            if (node) {
                fn.apply(node);
            }
        }
    }
    
    inRect(x1, y1, x2, y2) {    
        var nodes = [];
        for(var i in this.idList) {
            var id = this.idList[i];            
            var node = this.nodeManager.node(id);
            var view = node.view;
            if (view) {
                if (node.view.params.x >= x1
                    && node.view.params.y >= y1
                    && node.view.params.x + node.view.params.width <= x2
                    && node.view.params.y + node.view.params.height <= y2) {
                    nodes.push(id);
                }
            }
        }
        return new earb.NodeList(this.nodeManager, nodes);
    }
                    
    inside(node) {
        return this.inRect(
            node.view.params.x,
            node.view.params.y,
            node.view.params.x + node.view.params.width,
            node.view.params.y + node.view.params.height);   
    }
    
    not(notId) {
        var nodes = [];
        for(var i in this.idList) {
            var id = this.idList[i];            
            if(id != notId) {
                nodes.push(id);
            }
        }
        return new earb.NodeList(this.nodeManager, nodes);
    }
    
    /**
     * Возвращает связи между нодами в списке
     **/
    links() {
        var used = {};
        var ret = [];
        var nodeManager = this.nodeManager;
        this.each(function() {
            nodeManager.song.linkManager.byNode(this.params.id).each(function() {
                if(!used[this.id()]) {
                    ret.push(this.id());
                    used[this.id()] = true;
                }
            });
        });
        return new earb.LinkList(this.nodeManager.song.linkManager, ret);
    }
    
    /**
     * @todo mapParams - там хардкод параметров
     **/
    clone(additionalParams) {
    
        additionalParams.view = {
            x: 100,
            y: 100
        }
    
        var nodeManager = this.nodeManager;
        var lifetime = 1000;
        var clonedNodes = {};
        var clonedIds = [];
        
        // Клонируем ноды
        this.each(function() {
        
            var params = mod.deepCopy(this.storeParams());
            delete params.id;
            
            if(additionalParams) {
                for(var i in additionalParams) {
                    params[i] = additionalParams[i];
                }
            }
            
            var newNode = nodeManager.add(params);
            clonedNodes[this.params.id] = newNode;
            clonedIds.push(newNode.params.id);
       
        });
        
        var mapParams = function(params) {
        
            params = {
                src: params.src,
                dest: params.dest,
                srcPort: params.srcPort,
                destPort: params.destPort,
            };
        
            if(clonedNodes[params.src]) {
                params.src = clonedNodes[params.src].params.id;
            }
            if(clonedNodes[params.dest]) {
                params.dest = clonedNodes[params.dest].params.id;
            }
            return params;
        }
        
        // Клонируем линки
        this.links().each(function() {
            nodeManager.song.linkManager.add(mapParams(this.params));
        });   
        
        
        return new earb.NodeList(this.nodeManager, clonedIds);  
        
    }
    
    remove() {
        this.each(function() {
            this.remove();
        });
    }
    
    fire(event) {
        this.each(function() {
            this.fire(event);
        });
    }
                    
}