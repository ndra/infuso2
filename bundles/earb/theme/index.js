$(function() {
    
    var song = new earb({
        bpm: 120,
        timeSignature: [2,4]
    });
    
    var sine = song.instrument("sine").gain(.2);
    
    setTimeout(function() {
        sine.playNote(0,2000);
    }, 500);
    
//    $(window).blur(song.stop);

});
