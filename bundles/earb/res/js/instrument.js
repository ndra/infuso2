earb.instrument = function(song, instrumentParams) {

    earb.makeListener(this);
       
    var voices = [];
    
    var maxVoices = 10;
    
    var gain;
    
    var pattern;
    
    // Объект инструмента    
    Object.defineProperty(this, "song", {      
        get: function() {
            return song;
        }, set: function(p) {
            song = p;
        }
    });
    
    this.init = function() {
    
        gain = song.audioContext.createGain();
        gain.connect(song.audioContext.destination);
        gain.gain.value = .5;
    
        // Создаем голоса
        for(var i = 0; i < maxVoices; i ++) {
            voices[i] = new earb.voice(song.audioContext);
            voices[i].connect(gain);
        }

    }
    
    this.init();
       
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
    
    this.play = function(note) {
        this.getFreeVoice().play(note);
    }
    
    this.pattern = function(numberOfSteps) {    
        pattern = new earb.pattern(this, numberOfSteps);
        return pattern;    
    }
    
    this.handle32 = function(event) {
        pattern.handle32(event);
    }
    
    this.handleBar = function() {
    }
    

}
    
