$(function() {
    
    var song = new earb();
    song.scale(earb.scales.minor());
    var ambient = song.instrument("ambient1");
    var solo = song.instrument("sine").gain(.5);
    var bass = song.instrument("horn");
    
    var getRandomInt = function(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    var createPattern = function() {
        
        var oo = [1,1,1,-1,-1,-1,+2,-2,+5,-5,+7,-7];
        
        var s = "x(2) . x(2) . x(6) .  . . . . . .  x(2) . x(2) . x(6) . . . . . x(6) . . . . .   x(6) . . . . . . . . . . . . . . . .  . . . ."
        z = getRandomInt(0,7);
        s = s.replace(/x/g, function() {
            z += oo[getRandomInt(0,oo.length - 1)];
            //return getRandomInt(-2,12);
            return z;
        });
        return s;
        
    }

    song.frame(0,function() {
        
        //bass.pattern("1 . ");
        
        ambient.pattern(". . . . 1(12), . . . . . . . . . . .  0(12)  . . . . . . . . . . . 1(24) . . . . . . . . . . . . . . . . . . . .   ");
        ambient.degree(-14);
        
//        solo.pattern("1(2) . 2(2) . 3(6) .  . . . . . .  2(2) . 1(2) . 0(6) . . . . . 2(6) . . . . .   1(6) . . . . . . . . . . . . . . . .  . . . .");
        solo.degree(0);
        solo.onbar(function(n) {
            if(n.bar % 4 == 0) {
                solo.pattern(createPattern());    
            }
            //mod.msg("bar");
        })
        
        

    });
    
    setTimeout(function() {
        song.play();
    }, 500);
    
    $(window).blur(song.stop);

});
