earb.instrument = function(song, instrumentParams) {

    earb.makeListener(this);
       
    var voices = [];
    
    var maxVoices = 2;
    
    var gain;
    
    var pattern;
    
    var $e; // html элемент инструмента
    
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
    }
    
    this.init();
       
    /**
     * Возвращает первый свободный голос
     **/                         
    this.getFreeVoice = function() {
        var voice = new earb.voice(song.audioContext);
        voice.connect(gain);
        voices.push(voice);
        return voice;
    }
    
    this.play = function(note) {
        this.getFreeVoice().play(note);
    }
    
    this.pattern = function(numberOfSteps) {    
        pattern = new earb.pattern(this, numberOfSteps);
        return pattern;    
    }
    
    this.handle32 = function(event) {
        if(pattern) {
            pattern.handle32(event);
        }
        this.updateHTML();
    }
    
    this.handleBar = function() {
    }
    
    this.html = function() {
    
        $e = $("<div>")
            .css({
                width: 200,
                height: 100,
                border: "1px solid gray"
            }).appendTo("body");
    
    }
    
    this.updateHTML = function() {
    
        if(!$e) {
            return;
        }
        
        var html = "";
        for(var i in voices) {
            html += voices[i].isPlaying() ? "*" : "_";
        }
        $e.html(html);
        
    }
    

}
    
