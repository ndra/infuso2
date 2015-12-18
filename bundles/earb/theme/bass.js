$(function() {
    
    var song = new earb({
        bpm: 130
    });
    song.scale(earb.scales.minor(-1));
    var solo = song.instrument("sine").gain(.2);
    
    var solo2 = song.instrument("sine")
        .gain(.1);

    var bass = song.instrument("bass").gain(.2);
        
    var getRandomInt = function(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
        
    var pp = [
    ". . 3 .(2) 5 . .(2) 5 .(2) 5(2) 5(2) .(3) 3(2) . 3 7(3)",
    "5 . 1 1 . . 3 3(2) . . . .(3) . 7 1(2) .(2)",
    "15 12(3) 14 . . 15 . 3 . 10(3) .(2) .(2) .(3) 4(3) 2 11(2)",
    "12 13 . 5(2) .(3) 6(3) 7 15(3) 14(2) 3(2) .(3) . . .(2) 13(2) 10(2)",
    "5 . .(2) . 4(2) 6(2) 10 . 9 . . . .(3) . 15(2) 13",
    "7(2) 15(3) 14 . . . . 8 2 10 . .(3) 8 .(3) . 1",
    ".(2) . 8(2) .(3) .(3) 9 . 13(3) .(3) . . 14 14(3) 11 13(2) .",
    "10 . 3(3) 1 1 . 8(2) . . .(2) 14(2) 5 4(2) . 8(2) 1",
    "14(2) 1(3) . 14 . . 15 . .(2) 12 3 6 . 6(2) 3(2) .(3)",
    "8(2) .(3) . . 2 13(2) 12 1 2 2(2) .(2) . . 8 8(2) 1(3)",
    "10 8 .(2) 12 11(3) 12(2) . 15(3) 7 8 .(2) 6 15(3) . 7 12",
    "6(2) 12(3) . 3 . 12(3) 8 . .(2) 1 . .(3) . 14(2) . 14",
    ];

var ppp = [];

    song.frame(0,function() {
        
      // bass.pattern("8 . . . 8 8 . . . . . . .");
        
        solo.pattern("1- 5- 9 10   1- 5- 9- 10- 7-    1- 6- 6 5 4- 5- 6- 7 8 1 . ");
        //solo2.pattern("1- 5- 9 10   1- 5- 9- 10- 7-    1- 6- 6 5 4- 5- 6- 7 8 1 . ");
        solo.onbar(function(event) {
            solo2.degree(7);
            solo.degree(-7);
            
            if(event.bar >= 8) {
                if(event.bar % 8 == 0) {
                    
                    ppp[0] = pp[getRandomInt(0, pp.length-1)];
                    ppp[1] = pp[getRandomInt(0, pp.length-1)];
                    ppp[2] = ppp[0];
                    ppp[3] = pp[getRandomInt(0, pp.length-1)];
                    
                    //var generator = earb.generator(solo2, {});
                   // generator.generate().duration(16);
                    
                }
                
                solo2.pattern(ppp[event.bar % 4]).duration(16);
            }
            
        });
        
    });

    
    setTimeout(function() {
        song.play();    
        //bass1.playNote(3 - 12,1000);
    }, 500);
    
   $(window).blur(song.stop);
    
});
    