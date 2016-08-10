earb.pattern = function(channel, patternParams) {


    // Тик, от которого считать
    var startTick = null; 
    
    // Длительность шага ( 16 означает 1/16, 8 означает 1/8 и т.д.)
    var stepDuration = 16; 
    
    var pattern = [];   
    
    var patternObject = this;  
    
    var currentStep = 0;
    
    this.init = function() {
    
        if(typeof patternParams == "number") {
            patternParams = {
                numberOfSteps: patternParams
            };
        }
        
        if(patternParams.notes) {
            for(var i in patternParams.notes) {
                for(var j in patternParams.notes[i]) {
                    this.at(i).note(patternParams.notes[i][j]);
                }
            }
        }
    
    }  
   
    this.handle32 = function(event) {
    
        var tick = event.tick - startTick;  

        // Только ноты паттерна
        if(tick % (32 / stepDuration) != 0) {
            return;
        } 
        
        var step = (tick / (32 / stepDuration)) % patternParams.numberOfSteps;        
        this.handleStep(step);
    }
    
    this.handleStep = function(step) {
        var datas = pattern[step];
        if(datas) {      
            for(var i in datas) {
                var note = datas[i];
                if(note) {
                    note.play();
                }
            }
        }
        currentStep = step;
    }
    
    this.currentStep = function() {
        return currentStep;
    }
    
    this.channel = function() {
        return channel;
    }
    
    this.start = function() {
        startTick = channel.song().tick32();
    }  
    
    this.duration = function(p1) {
        if(arguments.length == 0) {
            return patternParams.numberOfSteps;
        } if(arguments.length == 1) {
            patternParams.numberOfSteps = p1;
            return this;
        }
    } 
    
    /**
     * Методя для создания / удаления нот
     **/
    this.at = function(position) {
        
        return new function() {
        
            this.note = function(params) {
            
                var song = channel.song;
                var note = song.note(params);
                note.channel = channel;
                
                if(!pattern[position]) {
                    pattern[position] = [];
                }
                pattern[position].push(note);            
            
                return patternObject;
            }
            
            this.clear = function() {
                pattern[position] = [];
                return patternObject;
            }
            
            this.notes = function() {
                return pattern[position] || [];
            }
        
        }();
    }    
    
    /**
     * Возвращает данные паттерна ввиде массива
     **/
    this.serialize = function() {
    
        // Общие параметры патрерна
        var data = {
            numberOfSteps: patternParams.numberOfSteps,
            notes: []    
        }
        
        // Записываем ноты
        for(var i = 0; i < patternParams.numberOfSteps; i ++) {
            var notes = this.at(i).notes();
            var stepData = [];
            for(var j in notes) {
                stepData.push(notes[j].serialize());
            }
            if(stepData.length) {
                data.notes[i] = stepData;
            }
        }
        
        return data;
    }
    
    this.init();
   
}