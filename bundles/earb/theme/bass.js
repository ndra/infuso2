$(function() {
    
    var song = new earb({
        bpm: 130
    });
    song.scale(earb.scales.minor(0));
    var solo = song.instrument("sine").gain(.5);
    var solo2 = song.instrument("sine").gain(.2);
    var amb = song.instrument("ambient1").gain(.4);
    var bass1 = song.instrument("sine").gain(.1);
    
    
    song.frame(0,function() {
    
        amb.pattern("1,5");
        bass1.pattern("1,8 1,8 . 1,8 1,8 1,8 1,8 . . 1,8 1,8 . 1,8 1,8  1,8 1,8 ");
        solo.pattern("1(2) . 5(2) . 9 10 1(2) .  8(2) . 9(2) .  10(2) . 7(2) . 1(2) .  6(2) . 6 5 4(2) . 5(2) . 6(2) . 7(2) 8  1 . ");
        //solo2.pattern(" 1 . 1(2) . 5(2) . 9 10 1(2) .  8(2) . 9(2) .  10(2) . 7(2) . 1(2) .  6(2) . 6 5 4(2) . 5(2) . 6(2) . 7(2) 8  ");
       // solo3.pattern(" 1 . 1(2) . 5(2) . 9 10 1(2) .  8(2) . 9(2) .  10(2) . 7(2) . 1(2) .  6(2) . 6 5 4(2) . 5(2) . 6(2) . 7(2) 8  ");
        //solo2.pattern(". 1(2) . 5(2) . 9 10 9(2) .  8(2) . 9(2) .  10(2) . 7(2) . 1(2) .  6(2) . 6 5 4(2) . 5(2) . 6(2) . 7(2) 8(3) . ");
       // bass1.pattern("1 2 3");
        //bass1.pattern(" -7(2) . 1(2) .");
        solo.onbar(function(event) {
            solo.degree(-7);
            solo2.degree(-7);
            bass1.degree(0);
            amb.degree(-7);
        });

        
    });
    
    song.frame(2,function() {
    
        //amb.pattern("-15");


        
    });
    
    setTimeout(function() {
        song.play();    
        //bass1.playNote(3 - 12,1000);
    }, 500);
    
   $(window).blur(song.stop);
    
});
    