$(function() {
    
    var song = new earb({
        bpm: 120
    });
    song.scale(earb.scales.minor());
    var horn = song.instrument("horn").gain(".02");
    var atm = song.instrument("fantasy");

    song.frame(0,function() {
        atm.pattern("1 . . .   . . . .   . . . .   . . . .  . . . .   . . . .   . . . .   . . . .");
        atm.onbar(function(event) {
            this.degree([0,-1,-2,-3][Math.floor(event.bar / 2) % 4])
        });
        
        //horn.pattern("1 2 3 4 2 3 4 5 3 4 5 6 4 5 6 7 ");
       // horn.pattern("1 . 1 .   . 2 . 2   . . . .   . . . .  . . . .   . . . .   . . . .   . . . .");
        horn.pattern(" . . . . . . . . . . . . 3 ")
        horn.onbar(function(event) {
            this.degree([0,-1,-2,-3][Math.floor(event.bar / 2) % 4])
        });
        
    });


    setTimeout(function() {
        //horn.playNote(10,1000);
        song.play();
    }, 1500);
    
    $(window).blur(song.stop);

});
