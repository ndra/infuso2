$(function() {
    
    var song = new earb({
        bpm: 120,
        timeSignature: [2,4]
    });
    
    var bass = song.instrument("ambient1"); 
    var bass2 = song.instrument("ambient1").gain(.1); 
    var bass3 = song.instrument("sine").gain(.3); 
    setTimeout(function() {
        bass.playNote(-12 * 2, 5000);
        
        bass3.playNote(5, 5000);
        //bass2.playNote(-10 + 7 * 4 + 5, 4000);
        //bass3.playNote(-10 + 7 * 3 + 3, 4000);
        //bass3.playNote(-10 + 7 * 3 + 5, 4000);
    }, 1000);
    
//    $(window).blur(song.stop);

});
