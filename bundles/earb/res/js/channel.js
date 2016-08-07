earb.channel = function(song, channelParams) {

    channelParams = earb.extend({}, channelParams);

    earb.makeListener(this);
    
    var channel = this;
       
    var voices = [];
   
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
        gain.gain.value = .2;   
        
        if(channelParams.name == "solo") {
        
            var convolver = song.audioContext.createConvolver();
            
            var concertHallBuffer, soundSource;
            
            var ajaxRequest = new XMLHttpRequest();
            ajaxRequest.open('GET', '/bundles/earb/res/convolution/irHall.ogg', true);
            ajaxRequest.responseType = 'arraybuffer';
            
            ajaxRequest.onload = function() {
                var audioData = ajaxRequest.response;
                song.audioContext.decodeAudioData(audioData, function(buffer) {
                    concertHallBuffer = buffer;
                    soundSource = song.audioContext.createBufferSource();
                    soundSource.buffer = concertHallBuffer;  
                    convolver.buffer = concertHallBuffer;
                });
                
            }
            
            ajaxRequest.send();
            
            convolver.connect(song.audioContext.destination);
            gain.connect(convolver);
        
        }  else {
            gain.connect(song.audioContext.destination);
        }
             
    }
    
    this.init();
       
    /**
     * Возвращает первый свободный голос
     **/                         
    this.getFreeVoice = function() {
        var voice = new earb.voice(song.audioContext, this);
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
        this.updateHTML(Math.floor(event.tick / 2 ) % 16);
    }
    
    this.handleBar = function() {
        this.clearVoices();
    }
    
    // Убрать этот метод
    this.name = function() {
        return channelParams.name;
    }
    
    this.html = function() {
    
        $e = $("<div>")
            .css({
                height: 50*10,
                border: "1px solid gray",
                position: "relative"
            }).appendTo("body");
            
        channel.$notes = {};
        channel.$cols = {};
    
        for(var i = 0; i < pattern.duration() ; i ++ ) {
        
            var $col = $("<div>").appendTo($e);
            channel.$cols[i] = $col;
        
            for(var j = 0; j < 10; j ++ ) {
            
                var degree = j + (channelParams.name == "solo" ? 0 : -21);
            
                var $note = $("<div>")
                    .css({
                        width: 40,
                        height: 40,
                        position: "absolute",
                        left: i * 50,
                        top: j * 50
                    })
                    .appendTo($col)
                    .data("degree", degree)
                    .data("position", i)
                    .mousedown(function() {
                        var place = pattern.at($(this).data("position"));
                        if(place.notes().length) {
                            place.clear();
                        } else {                            
                            place.clear();
                            place.note({
                                degree: $(this).data("degree"),
                                duration: 1
                            });
                        }
                        channel.updatePatternHTML();
                    });
                channel.$notes[i + "-" + degree] = $note;
            }
        }
        
        this.updatePatternHTML = function() {
        
            var notes = [];
            for(var i = 0; i < pattern.duration(); i ++) {
                var n = pattern.at(i).notes();
                for(var j in n) {
                    notes[i+ "-" + n[j].degree] = true;
                }
            }
            
            for(var i in channel.$notes) {
                channel.$notes[i].css("background", notes[i] ? "red" : "#ccc");
            };
    
        }
        
        this.updatePatternHTML();
    
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
    
    this.updateHTML = function(n) {
    
        for(var i in channel.$cols) {
            channel.$cols[i].css("opacity", i == n ? 1 : .8)
        }
        
    }
    

}
    
