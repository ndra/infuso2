earb.LinkList = class {

    constructor(linkManager, idList) {
        this.linkManager = linkManager;
        this.idList = idList;
    }
    
    each(fn) {
        for (var i in this.idList) {
            var link = this.linkManager.link(this.idList[i]);
            if (link) {
                fn.apply(link);
            }
        }
    }
    
    remove() {
        this.each(function() {
            this.remove();
        });
    }
                    
}