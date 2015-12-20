$(function() {
    
    var song = new earb({
        bpm: 130
    });
    song.scale(earb.scales.minor(-1));
    var solo = song.instrument("sine").gain(.1);

    var bass = song.instrument("sawtooth").gain(.3);

var ppp = [];

    song.frame(0,function() {
        
        bass.pattern("15(8)").duration(8);
        //solo.pattern("1- 5- 9 10   1- 5- 9- 10- 7-    1- 6- 6 5 4- 5- 6- 7 8 1 . ");
        solo.onbar(function(event) {
            solo.degree(-7);
            bass.degree(-7 * 3);
        });
        
    });

    
    setTimeout(function() {
        song.play();    
        //bass1.playNote(3 - 12,1000);
    }, 500);
    
   $(window).blur(song.stop);
    
});
    