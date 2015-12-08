$(function() {
    
    var song = new earb();
    song.scale(earb.scales.xminor());
    var bass1 = song.instrument("bass");
    var bass2 = song.instrument("bass");
    var fantasia = song.instrument("fantasia").gain(.5);
    
    song.frame(0,function() {
        
        fantasia.pattern("1 . . .    . . . .   . . . .   . . . . ");
        fantasia.onbar(function(event) {
            this.degree([0,3][event.bar % 2])
        });
        
        bass1.pattern("1 1 8 1 9 8 1 1 . 1 . . 1 . 1 .");
        bass1.onbar(function(event) {
            this.degree([0,3][event.bar % 2])
        });
        
        bass2.pattern("1 -6 2 -5 3 -4");
        bass2.onbar(function(event) {
            this.degree([0,3][event.bar % 2] + 7 * 3 )
        });
        
        /*bass2.pattern("1 1 8 1 9 8 1 1 . 1 . . 1 . 1 .");
        bass2.onbar(function(event) {
            this.degree([0,2,-3,-4][event.bar % 4])
        }); */
        
    });
    
    setTimeout(function() {
        song.play();    
    }, 500);
    
    $(window).blur(song.stop);
    
});
    