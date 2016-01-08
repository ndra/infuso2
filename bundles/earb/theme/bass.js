$(function() {
    
    var song = new earb({
        bpm: 130
    });
    song.scale(earb.scales.minor(-1));
   // var solo = song.instrument("sine").gain(.1);

    var bass = song.instrument("sawtooth").gain(.3);
    
    bass.pattern(4)
        .at(0).note({degree: -7 * 0 + 1})
        .at(1).note({degree: -7 * 0 + 2})
        .at(2).note({degree: -7 * 0 + 3})
        .at(3).note({degree: -7 * 0 + 4});

var ppp = [];

    song.frame(0,function() {
        
        //bass.pattern("1- 5- 9 10-------- ").duration(16);

        //solo.pattern("1- 5- 9 10   1- 5- 9- 10- 7-    1- 6- 6 5 4- 5- 6- 7 8 1 . ");
        /*solo.onbar(function(event) {
            solo.degree(-7);
            bass.degree(-7 * 3);
        }); */
        
    });

    
    setTimeout(function() {
        song.play();    
        //bass1.playNote(3 - 12,1000);
    }, 500);
    
   $(window).blur(song.stop);
    
});
    