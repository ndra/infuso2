earb.note = function(song, params) {

    var instrument;

    this.setParams = function(p) {
        params = earb.extend({
            degree : 1
        }, p); 
    }
    
    this.serialize = function() {
        return params;
    }
    
    this.setParams(params);

    // Объект песни    
    Object.defineProperty(this, "song", {      
        get: function() {
            return song;
        }, set: function(p) {
            song = p;
        }
    });
    
    // Объект инструмента    
    Object.defineProperty(this, "instrument", {      
        get: function() {
            return instrument;
        }, set: function(p) {
            instrument = p;
        }
    });

    // Нота
    var note = 0;      
    Object.defineProperty(this, "note", {      
        get: function() {
            var scale = song.scale();
            return scale.note(this.degree);
        }
    });
    
    // Ступень
    Object.defineProperty(this, "degree", {      
        set: function(p) {
            params.degree = p;
        }, get: function() {
            return params.degree;
        }
    });
    
    // Длительность (в 32-х)
    Object.defineProperty(this, "duration", {      
        set: function(p) {
            params.duration = p;
        }, get: function() {
            return params.duration;
        }
    });
    
    // Длительность ms
    Object.defineProperty(this, "durationMs", {      
        get: function(p) {
            return song.duration32() * this.duration; // TODO сделать
        }
    });
    
    // Частота
    Object.defineProperty(this, "frequency", {      
        get: function(p) {
            return song.getNoteFrequency(this.note); // TODO сделать
        }
    });
    
    this.play = function() {
        this.instrument.play(this);
    }

}
    
