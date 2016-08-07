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
        this.clearVoices();
    }
    
    this.html = function() {
    
        $e = $("<div>")
            .css({
                height: 50*10,
                border: "1px solid gray",
                position: "relative"
            }).appendTo("body");
            
        for(var i = 0; i < pattern.duration() ; i ++ ) {
        
            for(var j = 0; j < 10; j ++ ) {
                $("<div>")
                    .css({
                        width: 40,
                        height: 40,
                        position: "absolute",
                        left: i * 50,
                        top: j * 50,
                        background: "#ccc"
                    })
                    .appendTo($e)
                    .data("degree", j)
                    .data("position", i)
                    .click(function() {
                        pattern
                            .at($(this).data("position"))
                            .clear()
                            .at($(this).data("position"))
                            .note({
                                degree: $(this).data("degree") - 14,
                                duration: 1
                            });
                    });
            }
        }
    
    }
    
    this.clearVoices = function() {
        var newVoices = [];
        for(var i in voices) {
            if(voices[i].isPlaying()) {
                newVoices.push(voices[i]);
            }
        }
        voices = newVoices;
    }
    
    this.updateHTML = function() {
    
        /*if(!$e) {
            return;
        }
        
        var html = "";
        for(var i in voices) {
            html += voices[i].isPlaying() ? "*" : "_";
        }
        $e.html(html); */
        
    }
    

}
    
