window.earb = function(params) {

    this.params = params;
    
    var extend = function(obj, extend) {
        if(!obj) {
            obj = {};
        }
        for(var i in extend) {
            if(obj[i] === undefined) {
                obj[i] = extend[i];
            }
        }
        return obj;
    }
    
    this.params = extend(this.params, {
        bpm: 120,
        timeSignature: [4,4],
    });
    
    var earb = this;   

    this.audioContext = new window.AudioContext();        
    this.soundEnabled = true;

    this.frames = [];
    var tick32 = 0;
    
    var scale = window.earb.scales.minor(0);
    
    this.instruments = [];
    
    var interval = null;

    this.frame = function(time, callback) {
        this.frames[time] = callback;
    }
    
    /**
     * Обработчик каждой 1/32 ноты
     **/         
    this.handle32 = function() { 
        var n = 32 / earb.params.timeSignature[1] * earb.params.timeSignature[0];           
        
        var timeEvent = {
            tick : tick32,
            barTick: tick32 % n,
            bar: Math.floor(tick32 / n),
        }
            
        if(tick32 % n == 0 ) {
            earb.handleBar(timeEvent);
        }
        if(tick32 % (32 / earb.params.timeSignature[1]) == 0 ) {
            // Доля. Пока ничего не делаем с этим                    
        }
        
        for(var i in earb.instruments) {
            earb.instruments[i].handle32(timeEvent);
        }
        
        tick32 ++;
    }
    
    /**
     * Обрабатывает начало такта
     **/                         
    this.handleBar = function(event) {
        var fn = earb.frames[event.bar];
        if(fn) {
            fn.apply(earb);
        }
    }
    
    /**
     * Проигрывает композицию
     **/         
    this.play = function() {
    
        tick32 = 0;
        
        // Длительность 1/32 ноты 
        var duration4 = 60 / 120;
        var duration32 = duration4 / 8;
        
        interval = setInterval(this.handle32, duration32 * 1000);
        
    }   
    
    this.stop = function() {
        clearInterval(interval);
    }      
  
    /**
     * Возвращает частоту ноты
     **/         
    this.getNoteFrequency = function(note) {
        note += 36;
        var frequency = 27.5 * Math.pow(2, note / 12);
        return frequency;
    }
    
    /**
     * Создает новый инструмент
     **/         
    this.instrument = function(params) { 
        return new window.earb.instrument(this,params);
    } 
    
    this.tick32 = function() {
        return tick32;
    }
    
    /**
     * Возвращает гамму (тональность) песни
     **/         
    this.scale = function() {
        return scale;
    }
    

    
};

// ----------------------------------------------------------------------------- Инструмент

earb.instrument = function(song, params) {
        
    song.instruments.push(this);
        
    this.params = {};
    this.params.monophonic = false;
    
    var patternObject = null;

    var maxVoices = 10;
    var voices = [];
    var instrument = this;
    
    // Создаем голоса
    for(var i = 0; i < maxVoices; i ++) {
        voices[i] = new function() {                
            this.amp = song.audioContext.createGain();
            this.amp.connect(song.audioContext.destination);
            this.amp.gain.value = 0;
            this.oscillator = song.audioContext.createOscillator();
            this.oscillator.connect(this.amp);
            this.oscillator.type = 'sawtooth';
            this.oscillator.start(0);
        }();
    }
    
    /**
     * Возвращает первый свободный голос
     **/                         
    this.getFreeVoice = function() {
        for(var i = 0; i < maxVoices; i ++) {
            if(!voices[i].playing) {
                return voices[i];
            }                
        }
        alert("Too many voices");
    }

    /**
     * Проигрывает заданную ноту
     **/         
    this.playNote = function(p1,p2) {
    
        if(!song.soundEnabled) {
            return;
        }
        
        var signature = (typeof p1)+":"+(typeof p2);
        
        switch(signature) {
            case "object:undefined":
                params = p1;
                break;
            case "number:number":
                params = {
                    note:p1,
                    duration: p2
                };
                break;
            default:                    
                alert("interument.playNode bad params " + signature);
                break;
        }              
  
        if(instrument.params.monophonic) {
            var voice = voices[0];
            voice.oscillator.frequency.value = song.getNoteFrequency(params.note);
            voice.amp.gain.value = .3;
        } else {
            var voice = this.getFreeVoice(); 
            voice.oscillator.frequency.setValueAtTime(song.getNoteFrequency(params.note),0);
            voice.amp.gain.value = .3;
            voice.playing = true;
            setTimeout(function() {
                voice.amp.gain.value = 0;
                voice.playing = false;
            }, params.duration);
        }
    }
    
    /**
     * Обработчик 32 ноты
     **/                         
    this.handle32 = function(tick) {
        if(patternObject) {
            patternObject.handle32(tick);    
        }
    }         
    
    this.pattern = function(params) {
        patternObject = new window.earb.pattern(this, params);
        return patternObject;
    }       
    
    this.song = function() {
        return song;
    }     
          
}

// ----------------------------------------------------------------------------- Паттерн

earb.pattern = function(instrument, params) {

    var pattern = {
        1: {stage: 1, duration: 60},
        2: {stage: 2, duration: 60},
        3: {stage: 3, duration: 60},
        4: {stage: 4, duration: 60},
        5: {stage: 5, duration: 60},
        6: {stage: 6, duration: 60},
    };
    
    var startTick = null; // Тик, от которого считать
    
    var stepDuration = 16; // Длительность шага ( 16 означает 1/16, 8 означает 1/8 и т.д.)
    
    var numberOfSteps = 6; // Количество шагов в паттерне
    
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
        var data = pattern[step + 1];
        if(data) {
            var note = instrument.song().scale().note(data.stage);
            instrument.playNote(note,data.duration);
        }
    }
    
    this.start = function() {
        startTick = instrument.song().tick32();
    }   
    
}

// ----------------------------------------------------------------------------- Гаммы

earb.createScales = function() {

    // Создаем гаммы
    earb.scales = {};
    
    var scaleSchemes = {
        minor: [1, 3, 4, 6, 8, 9, 11],
        hminor: [1, 3, 4, 6, 8, 9, 12],
        major: [1, 3, 5, 6 + 1, 8, 10, 12],
        xminor: [1, 3, 4, 6, 8, 10, 11]
    };
    
    for(var name in scaleSchemes) {
        earb.scales[name] = function(tonic) {
            return new function() {
                var steps = scaleSchemes[name];
                this.note = function(step) {
                    step --;
                    var octave = Math.floor(step / steps.length);
                    return steps[step - octave * steps.length] - 1 + octave * 12 + tonic;
                }
            }();
        };
    }
};
earb.createScales();
    
