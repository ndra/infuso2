earb.NodeList = class {

    constructor(song, idList) {
        this.song = song;
        this.idList = idList;
    }
    
    each(fn) {
        for (var i in this.idList) {
            var node = this.song.node(this.idList[i]);
            if (node) {
                fn.apply(node);
            }
        }
    }
    
    inRect(x1, y1, x2, y2) {    
        var nodes = [];
        for(var i in this.idList) {
            var id = this.idList[i];            
            var node = this.song.node(id);
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
        return new earb.NodeList(this.song, nodes);
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
        return new earb.NodeList(this.song, nodes);
    }
    
    clone() {
    
        var song = this.song;
        var lifetime = 1000;
        var clonedNodes = {};
        
        // Клонируем ноды
        this.each(function() {
            var newNode = song.addNode(this.params);
            clonedNodes[this.params.id] = newNode;
            setTimeout(function() {
                song.removeNode(newNode.params.id)
            }, lifetime);        
        });
        
        // Клонируем линки
        for(var i in this.song.links) {
            var link = this.song.links[i];
            if(link.params.src)
        }
        
    }
                    
}