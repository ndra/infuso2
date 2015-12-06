$(function() {
    
    var song = new earb();
    song.scale(earb.scales.xminor());
    var bass1 = song.instrument("bass");
    var bass2 = song.instrument("bass");
    var solo = song.instrument("solo");

    song.frame(0,function() {
        bass1.pattern("1 1 8 1 9 8 1 1 . 1 . . 1 . 1 .");
        bass1.onbar(function(event) {
            this.degree([0,2,-3,-4][event.bar % 4] - 7)
        });
    });
    
    song.frame(4,function() {
        bass2.pattern("1 1 8 1   1 1 8 1  1 1 8 1  1 1 8 1");
        bass2.onbar(function(event) {
            this.degree([0,2,-3 + 7,-4 + 7][event.bar % 4] - 7 * 2)
        });
    });
    
    song.frame(8,function() {
        solo.pattern("1 2 3 4 5 6 7 6 5 4 3 2 7 6 5 4 6 5 4 3 5 4 3 2");
        solo.onbar(function(event) {
            this.degree([0,2,-3,-4][event.bar % 4] + 7)
        });
    });
    
    song.play();
    
    $(window).blur(song.stop);

});
