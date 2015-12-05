window.earb = new function() {

    var audioContext = new window.AudioContext();
    var earb = this;       
    this.soundEnabled = true;
    
    /**
     * Возвращает частоту ноты
     **/         
    this.getNoteFrequency = function(note) {
        note += 48;
        note -= 12;
        var frequency = 27.5 * Math.pow(2, note / 12);
        return frequency;
    }
    
    /**
     * Создает новый инструмент
     **/         
    this.instrument = function() { 
        return new function() {
        
            this.params = {};
            this.params.monophonic = false;
        
            var maxVoices = 10;
            var voices = [];
            var instrument = this;
            
            for(var i = 0; i < maxVoices; i ++) {
                voices[i] = new function() {                
                    this.amp = audioContext.createGain();
                    this.amp.connect(audioContext.destination);
                    this.amp.gain.value = 0;
                    this.oscillator = audioContext.createOscillator();
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
            
                if(!earb.soundEnabled) {
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
            
                if(!params) {
                    params = {
                        duration: 1000,
                        note: 0
                    };
                }
            
                if(instrument.params.monophonic) {
                    var voice = voices[0];
                    voice.oscillator.frequency.value = earb.getNoteFrequency(params.note);
                    voice.amp.gain.value = .3;
                } else {
                    var voice = this.getFreeVoice(); 
                    voice.oscillator.frequency.setValueAtTime(earb.getNoteFrequency(params.note),0);
                    voice.amp.gain.value = .3;
                    voice.playing = true;
                    setTimeout(function() {
                        voice.amp.gain.value = 0;
                        voice.playing = false;
                    }, params.duration);
                }
            }
            
            this.pattern = function(p, scale) {
                return new function() {
                
                    this.params = p;    
                
                    if(!this.params.speed) {
                        this.params.speed =  125;
                    }
                    if(!this.params.shift) {
                        this.params.shift = 0;
                    }
                                                  
                    var patternObject = this;  
                    var iterator = 0;           
                    var onStep = function() {};
                    this.play = function() {
                        setInterval(function() {
                            patternObject.step()
                        }, this.params.speed);
                    };
                    this.step = function() {
                    
                        if(iterator % this.params.pattern.length == 0) {
                            onStep.apply(this, [Math.floor(iterator / this.params.pattern.length)]);
                            this.params.shift += this.params.shiftNext;
                        }  
                    
                        var patternStep = this.params.pattern[iterator % this.params.pattern.length] * 1;
                        instrument.playNote({
                            note: scale.note(patternStep + this.params.shift),
                            duration: this.params.speed
                        });                           
                        iterator ++;    
                   
                    };  
                    
                    this.setPattern = function(pattern) {
                        this.params.pattern = pattern;
                    }
                    
                    this.shift = function(s) {
                        this.params.shift = s;
                    }
                    
                    this.onStep = function(fn) {
                        onStep = fn;
                    }
                                    
                }();
            };
            
        }();
    } 
    
    // Создаем гаммы
    this.scales = {};
    
    var scaleSchemes = {
        minor: [1, 3, 4, 6, 8, 9, 11],
        hminor: [1, 3, 4, 6, 8, 9, 12],
        major: [1, 3, 5, 6 + 1, 8, 10, 12],
        xminor: [1, 3, 4, 6, 8, 10, 11]
    };
    
    for(var name in scaleSchemes) {
        this.scales[name] = function(tonic) {
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
    
    // -------------------------------------------------------------------------
    // Композиция
    
    this.song = function() {    
        return new function() {
        
            var song = this;
        
            this.params = {
                bpm: 120,
                timeSignature: [4,4], // Размер
            };
        
            this.frames = [];
            this.tick32 = 0;
        
            this.frame = function(time, callback) {
                this.frames[time] = callback;
            }
            
            this.handle32 = function() { 
                var n = 32 / song.params.timeSignature[1] * song.params.timeSignature[0];               
                if(song.tick32 % n == 0 ) {
                    song.handleBar(song.tick32 / n);
                }
                if(song.tick32 % (32 / song.params.timeSignature[1]) == 0 ) {
                    // Доля. Пока ничего не делаем с этим                    
                }
                song.tick32 ++;
            }
            
            /**
             * Обрабатывает начало такта
             **/                         
            this.handleBar = function(counter) {
                var fn = song.frames[counter];
                if(fn) {
                    fn.apply(song);
                }
            }
            
            this.play = function() {
            
                song.tick32 = 0;
                
                // Длительность 1/32 ноты 
                var duration4 = 60 / 120;
                var duration32 = duration4 / 8;
                
                setInterval(this.handle32, duration32 * 1000);
                
            }
        
        }();
        
    };

}();