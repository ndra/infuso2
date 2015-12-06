window.earb = function(params) {

    this.params = params;
    
    this.params = window.earb.extend(this.params, {
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
        for(var i in earb.instruments) {
            earb.instruments[i].handleBar(event);
        }
    }
    
    /**
     * Проигрывает композицию
     **/         
    this.play = function() {    
        tick32 = 0;        
        interval = setInterval(this.handle32, this.duration32());          
    }   
    
    this.stop = function() {
        clearInterval(interval);
    }      
  
    /**
     * Возвращает частоту ноты
     **/         
    this.getNoteFrequency = function(note) {
        note += 48;
        var frequency = 27.5 * Math.pow(2, note / 12);
        return frequency;
    }
    
    /**
     * Создает новый инструмент
     **/         
    this.instrument = function(params) { 
        return new window.earb.instrument(this,params);
    } 
    
    this.sample = function(params) {
        return new window.earb.sample(this, params);
    }
    
    this.tick32 = function() {
        return tick32;
    }
    
    /**
     * Возвращает гамму (тональность) песни
     **/         
    this.scale = function(p1) {
        if(arguments.length == 0) {
            return scale;
        } else if(arguments.length == 1) {
            scale = p1;
            return this;
        }
    }
    
    /**
     * Возвращает длительность 32 ноты в миллисекундах
     **/         
    this.duration32 = function() {
        var duration4 = 60 / this.bpm();
        var duration32 = duration4 / 8;
        return duration32 * 1000;
    }
    
    this.bpm = function() {
        return this.params.bpm;
    }
    

    
};

// ----------------------------------------------------------------------------- Инструмент

earb.instrument = function(song, name) {
        
    song.instruments.push(this);
        
    var instrumentParams = earb.instruments[name];
    
    if(!instrumentParams) {
        alert("Undefined instrument " + name);
    }
    
    var patternObject = null;

    var maxVoices = 40;
    var voices = [];
    var instrument = this;
    
    var sample = song.sample(instrumentParams);
    
    var degree = 0;
    
    var handlers = {};
    
    var gain = .3;
    
    var iscale = null;
    
    this.onbar = function(fn) {
        this.on("bar",fn)
    };
    
    this.on = function(name, fn) {
        handlers[name] = [fn];
    }
    
    this.fire = function(name, params) {
        var hh = handlers[name];
        for(var i in hh) {
            hh[i].apply(this,[params]);
        }
    };
    
    // Создаем голоса
    for(var i = 0; i < maxVoices; i ++) {
        voices[i] = new function() { 
        
            var voice = this; 
        
            var isPlaying = false;
            
            var amp = song.audioContext.createGain();
            amp.connect(song.audioContext.destination);
            amp.gain.value = 0;
            
            var gain;
            
            var sampleController;
        
            this.isPlaying = function() {
                return isPlaying;
            }
            
            this.play = function(params) {

                sampleController = sample.start(amp, params.frequency);
                isPlaying = true;
                
                gain = instrument.gain();

                var now = song.audioContext.currentTime;
                var d = 0;                
                // Начало
                amp.gain.setValueAtTime(0, now);
                // Атака
                d += params.attackDuration / 1000;
                amp.gain.linearRampToValueAtTime(gain * params.attackGain, now + d);
                
                // Спад
                d += params.decayDuration / 1000;
                amp.gain.linearRampToValueAtTime(gain * params.sustainGain, now + d);
                
                // Сустейн
                d = params.duration / 1000;
                amp.gain.linearRampToValueAtTime(gain * params.sustainGain, now + d);
                
                setTimeout(this.release, d * 1000);
                
            }
            
            this.release = function() {
                amp.gain.linearRampToValueAtTime(0,  song.audioContext.currentTime + params.releaseDuration / 1000);
                sampleController.release();
                setTimeout(voice.stop, params.releaseDuration);
            }
            
            this.stop = function() {
                sampleController.stop();
                isPlaying = false;
            }

        }();
    }
    
    /**
     * Возвращает первый свободный голос
     **/                         
    this.getFreeVoice = function() {
        for(var i = 0; i < maxVoices; i ++) {
            if(!voices[i].isPlaying()) {
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

        var voice = this.getFreeVoice(); 
        params.frequency = song.getNoteFrequency(params.note);
        params.attackDuration = instrumentParams.attackDuration;
        params.attackGain = instrumentParams.attackGain;
        params.decayDuration = instrumentParams.decayDuration;
        params.sustainGain = instrumentParams.sustainGain;
        params.releaseDuration = instrumentParams.releaseDuration;
        voice.play(params);

    }
    
    /**
     * Обработчик 32 ноты
     **/                         
    this.handle32 = function(tick) {
        if(patternObject) {
            patternObject.handle32(tick);    
        }
    }     
    
    this.handleBar = function(event) {
        this.fire("bar", event);
    }        
    
    this.pattern = function(params) {
        patternObject = new window.earb.pattern(this, params);
        return patternObject;
    }       
    
    this.song = function() {
        return song;
    }
    
    this.degree = function(p1) {
        if(arguments.length == 0) {
            return degree;
        } else if(arguments.length == 1) {
            degree = p1;
            return this;
        }
    }  
    
    this.scale = function(p1) {
        if(arguments.length == 0) {
            if(iscale) {
                return iscale;
            } else {
                return song.scale();
            }
        } if(arguments.length == 1) {
            iscale = p1;
            return this;
        }
    }   
    
    this.gain = function(p1) {
        if(arguments.length == 0) {
            return gain;
        } if(arguments.length == 1) {
            gain = p1;
            return this;
        }
    }        
          
}

// ----------------------------------------------------------------------------- Паттерн

earb.pattern = function(instrument, params) {

    var startTick = null; // Тик, от которого считать
    
    var stepDuration = 16; // Длительность шага ( 16 означает 1/16, 8 означает 1/8 и т.д.)
    
    var numberOfSteps = 1; // Количество шагов в паттерне
    
    var pattern = [];

    this.parsePattern = function(pat) {
    
        pat = pat.trim();
        pat = pat.replace(/\s+/g," ");
        pat = pat.split(" ");
        
        var n = 1;
        
        var parseCommand = function(cmd) {
        
            if(cmd.match(/^-?\d+$/)) {
            
                if(!pattern[n]) {
                    pattern[n] = [];
                }
                    
                pattern[n].push({
                    degree: cmd * 1,
                    duration: 32 / stepDuration
                });
            }
            
        }
        
        for(var i in pat) {
            var step = pat[i];
            var commands = step.split(",");
            for(var i in commands) {
                var command = commands[i];
                parseCommand(command);
            }  
            n++;      
        }
        
        numberOfSteps = n - 1;
    
    }
    
    this.parsePattern(params);  
   
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
        var datas = pattern[step + 1];
        if(datas) {      
            for(var i in datas) {
                var data = datas[i];
                var degree = data.degree + instrument.degree();
                var note = instrument.scale().note(degree);
                var duration = instrument.song().duration32() * data.duration;
                instrument.playNote(note, duration);
            }
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
        major: [1, 3, 5, 6, 8, 10, 12],
        xminor: [1, 3, 4, 6, 8, 10, 11],
        arabic: [1, 3, 4, 6, 7, 9, 10, 12],
        blues: [1, 4, 6, 7, 8, 11],
    };
    
    var createScale = function(name, scheme) {
        earb.scales[name] = function(tonic) {
        
        
            if(!tonic) {
                tonic = 0;
            }
        
            return new function() {
                var steps = scheme;
                this.note = function(step) {
                    step --;
                    var octave = Math.floor(step / steps.length);
                    return steps[step - octave * steps.length] - 1 + octave * 12 + tonic;
                }
            }();
        };
    }
    
    for(var name in scaleSchemes) {
        createScale(name, scaleSchemes[name]);
    }
};
earb.createScales();

// -----------------------------------------------------------------------------

earb.sample = function(song, params) {
 
    var context = song.audioContext;
    
    var buffer;       
    
    var request = new XMLHttpRequest();
    request.open('GET', params.sample, true); 
    request.responseType = 'arraybuffer';
    request.onload = function() {
        context.decodeAudioData(request.response, function(response) {

            if(params.loopBidi) {
            
                var bytesLoopFrom = Math.round(params.loopFrom * response.sampleRate);
                var bytesLoopTo = Math.round(params.loopTo * response.sampleRate);
                var bytesLoop = Math.round(bytesLoopTo - bytesLoopFrom);
    
                buffer = context.createBuffer(
                    response.numberOfChannels,
                    response.length + bytesLoop * 2,
                    response.sampleRate
                );
                
                for(var i = 0; i < response.length; i ++) {
                    if(i < bytesLoopFrom) {
                        buffer.getChannelData(0)[i] = response.getChannelData(0)[i];
                    }
                    if(i >= bytesLoopFrom && i <= bytesLoopTo) {
                        buffer.getChannelData(0)[i] = response.getChannelData(0)[i];
                        buffer.getChannelData(0)[bytesLoopFrom + bytesLoop * 2 - (i - bytesLoopFrom)] = response.getChannelData(0)[i];
                        buffer.getChannelData(0)[i + bytesLoop * 2] = response.getChannelData(0)[i];
                    }
                    if(i >= bytesLoopTo) {
                        buffer.getChannelData(0)[i + bytesLoop * 2] = response.getChannelData(0)[i];
                    }
                }
            
            } else {
                buffer = response;
            }
            
        });
    };
    request.send();
    
    this.start = function(destination, frequency) {
    
        var source = context.createBufferSource();
        source.connect(destination);
            
        source.playbackRate.value = frequency / params.sampleFrequency;
        source.buffer = buffer;
        source.loopStart = params.loopFrom;
        source.loopEnd = params.loopTo + (params.loopTo - params.loopFrom);
        source.loop = true;
        source.start();
        
        return new function() {
            this.release = function() {
                //source.loopStart = buffer.duration - .01;
                //source.loopEnd = buffer.duration;
            }
            this.stop = function() {
                source.stop();
            }
        }();
        
    }

}

// ----------------------------------------------------------------------------- Утилиты

earb.extend = function(obj, extend) {
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

// -----------------------------------------------------------------------------

earb.instruments = {
    bass: {
        attackDuration: 50,
        attackGain: 1,
        decayDuration: 100,
        sustainGain: .1,
        releaseDuration: 300,
        loopFrom: 0.583,
        loopTo: 0.583 + 0.0150 * 5,
        sample: '/bundles/earb/res/sounds/accoustic-bass.wav',
        sampleFrequency: 246.96
    }, fantasy: {
        attackDuration: 50,
        attackGain: 1,
        decayDuration: 100,
        sustainGain: .8,
        releaseDuration: 5000,
        loopFrom: 0.7621660430915653,
        loopTo: 1.9586443684063852,
        loopBidi: true,
        sample: '/bundles/earb/res/sounds/fantasia.wav',
        sampleFrequency: 523.25 // Нота до второй октавы
    }, horn: {
        attackDuration: 50,
        attackGain: 1,
        decayDuration: 100,
        sustainGain: .8,
        releaseDuration: 100,
        loopFrom: 0.487815,
        loopTo: 1.701875,
        loopBidi: true,
        sample: '/bundles/earb/res/sounds/horn.wav',
        sampleFrequency: 293.66
    },
}
    
