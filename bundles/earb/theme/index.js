$(function() {
    
    var getRandomInt = function(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
    var song = new earb({
        bpm: 120,
        timeSignature: [2,4]
    });
    song.scale(earb.scales.minor());
    var bass1 = song.instrument("horn");
    var bass2 = song.instrument("horn");
    var solo = song.instrument("sine").gain(.3);
    
    var ql = 8;
    
    var options;
    
        var ooo = [
            [1,1,1,1,2,2,3,-1,-1,-2,-3],
            [3,4,5,-1,-1,-1]
        ];
        
    var diceOptions = function() {
        options = ooo[getRandomInt(0,ooo.length - 1)];    
    }
    
    var createPattern = function() {
        
        var ret = [];
        
        var degrees = [1,3,5,1,3,5,1,3,5,2,4,6,7];
        
        while(true) {
        
            var symbol;
            
            var option = options[getRandomInt(0,options.length - 1)];
            var d = Math.abs(option);
            
            switch(option) {
                case 1:
                case 2:
                case 3:
                    symbol = degrees[getRandomInt(0,degrees.length - 1)] + "";
                    if(getRandomInt(0,1) == 1) {
                        symbol = symbol + "," + (symbol * 1 - 7);
                    }
                    
                    
                    break;
                case -1:
                case -2:
                case -3:
                    symbol = ".";
                    break;
            }
            
            for(var i = 0; i < d; i ++ ) {
                ret.push(symbol);
                if(ret.length == ql) {
                    break;
                }
            }
            
            if(ret.length == ql) {
                break;
            }
        
        }
        
        mod.msg(ret.join(" "));
        
        return ret.join(" ");
    }
    
    var patterns = ["","","",""];

    song.frame(0,function() {
        
        bass1.onbar(function(event) {
            this.degree([0,-1,-2,-3][event.bar % 4] - 7);
            
            if(event.bar % 16 == 0) {
                switch(getRandomInt(0,2)) {
                    case 0:
                        bass1.pattern("1 1 8 1   1 1 8 1  1 1 8 1  1 1 8 1");
                        break;
                    case 1:
                        bass1.pattern("1 1 8 1 9 8 1 1 . 1 . . 1 . 1 .");
                        break;
                    case 2:
                        bass1.pattern("1 1 ..   1 1 .  1 1 ..  1 1 ..");
                        break;
                }
            }
            
        });
        
        solo.onbar(function(event) {
            
            if(event.bar % 8 == 0) {
                
                diceOptions();
                
                for(var i = 0; i < 4; i ++) {
                    patterns[i] = createPattern();
                }
                
                patterns[2] = patterns[0];
                //patterns[3] = patterns[1];
                
            }
            
            if(event.bar % 8 == 7 || event.bar % 8 == 6) {
                this.degree(getRandomInt(-7,7));
            } else {
                this.degree(0);
            }
            
            
            solo.pattern(patterns[event.bar % 4]);
            
        })
    });

    setTimeout(function() {
        song.play();
    }, 1000);
    
    $(window).blur(song.stop);

});
