window.earb = function(params) {

    this.params = params;
    
    this.params = window.earb.extend({
        bpm: 120,
        timeSignature: [4,4],
    }, this.params);
    
    var earb = this;   

    this.audioContext = new window.AudioContext();    
    
    var tick32 = 0;

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
        
        for(var i in earb.channels) {
            earb.channels[i].handle32(timeEvent);
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
        for(var i in earb.channels) {
            earb.channels[i].handleBar(event);
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
     * Создает новый инструмент
     **/         
    this.channel = function(params) { 
        var channel = new window.earb.channel(this, params);
        this.channels.push(channel);
        return channel;
    } 
    
    this.note = function(params) { 
        return new window.earb.note(this, params);
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
    
    /**
     * Возвращает bpm песни
     **/         
    this.bpm = function() {
        return this.params.bpm;
    }        

    
};

/**
 * Возвращает частоту ноты
 **/         
earb.getNoteFrequency = function(note) {
    note *= 1;
    note += 48;
    var frequency = 27.5 * Math.pow(2, note / 12);
    return frequency;
}

// ----------------------------------------------------------------------------- Типы нод

earb.nodeTypes = {};

earb.registerNodeType = function(c, type) {
    earb.nodeTypes[type] = c;
}

earb.getNodeConstructor = function(type) {
    return earb.nodeTypes[type];
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

// ----------------------------------------------------------------------------- Утилиты

earb.extend = function(obj, extend) {
    if(!obj) {
        obj = {};
    }    
    if(!extend) {
        extend = {};
    }
    for(var i in extend) {
        obj[i] = extend[i];
    }
    return obj;
}