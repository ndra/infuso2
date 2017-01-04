earb.LinkList = class {

    constructor(song, idList) {
        this.song = song;
        this.idList = idList;
    }
    
    each(fn) {
        for (var i in this.idList) {
            var link = this.song.link(this.idList[i]);
            if (link) {
                fn.apply(link);
            }
        }
    }
                    
}