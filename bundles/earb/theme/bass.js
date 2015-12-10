$(function() {
    
    var song = new earb({
        bpm: 140
    });
    song.scale(earb.scales.minor(-1));
    var bass1 = song.instrument("sine");
    var bass2 = song.instrument("bass");
    var fantasia = song.instrument("fantasia").gain(.5);
    
    song.frame(0,function() {
    
        
        bass1.pattern("0 . 7 . 8 9 8 .  7 . 8 .  9 . 7 . ");
        bass1.onbar(function(event) {
            //this.degree([0,3][event.bar % 2])
        });

        
    });
    
    setTimeout(function() {
        song.play();    
    }, 500);
    
    $(window).blur(song.stop);
    
});
    