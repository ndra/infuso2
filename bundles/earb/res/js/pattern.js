earb.pattern = function(instrument, params) {

    // Тик, от которого считать
    var startTick = null; 
    
    // Длительность шага ( 16 означает 1/16, 8 означает 1/8 и т.д.)
    var stepDuration = 16; 
    
    // Количество шагов в паттерне
    var numberOfSteps = params; 
    
    var pattern = [];   
    
    var patternObject = this;    
   
    this.handle32 = function(event) {
    
        var tick = event.tick - startTick;  

        // Только ноты паттерна
        if(tick % (32 / stepDuration) != 0) {
            return;
        } 
        
        var step = (tick / (32 / stepDuration)) % numberOfSteps;        
        this.handleStep(step);
    }
    
    this.handleStep = function(step) {
        var datas = pattern[step];
        if(datas) {      
            for(var i in datas) {
                var note = datas[i];
                if(note) {
                    console.log(step);
                    note.play();
                }
            }
        }
    }
    
    this.instrument = function() {
        return instrument;
    }
    
    this.start = function() {
        startTick = instrument.song().tick32();
    }  
    
    this.duration = function(p1) {
        if(arguments.length == 0) {
            return numberOfSteps;
        } if(arguments.length == 1) {
            numberOfSteps = p1;
            return this;
        }
    } 
    
    this.at = function(position) {
    
        var song = instrument.song;
        var note = song.note();
        note.instrument = instrument;
        
        if(!pattern[position]) {
            pattern[position] = [];
        }
        pattern[position].push(note);
        
        return new function() {
        
            this.note = function(params) {
                note.setParams(params);
                return patternObject;
            }
        
        }();
    }    
   
}