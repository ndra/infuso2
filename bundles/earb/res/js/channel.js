earb.channel = function(song, channelParams) {
   
    var channel = this;
   
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
    
        earb.makeListener(this);    
    
        // Дополняем настройки настройками по умолчагию (пока их нет) 
        channelParams = earb.extend({}, channelParams);

        // Пытаемся загрузить данные
        channelParams = earb.extend(channelParams, this.loadData());
        
        if(channelParams.pattern) {
            this.pattern(channelParams.pattern);
        }
    
        gain = song.audioContext.createGain();
        gain.gain.value = .2;   
        
        /*if(channelParams.name == "solow") {
        
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
        
        }  else {  */
            gain.connect(song.audioContext.destination);
        //}                         
    } 
    
    this.play = function(note) {
        this.instrument.play(note);
    }
    
    this.handle32 = function(event) {
        if(pattern) {
            pattern.handle32(event);
        }
        this.fire("1/32", event);
    }
    
    this.handleBar = function() {
        this.clearVoices();
    }
    
    // Убрать этот метод
    this.name = function() {
        return channelParams.name;
    }
    
    /**
     * ВОзвращает / изменяет паттерн
     **/
    this.pattern = function(p1) {
        if(arguments.length == 0) {
            return pattern;
        } if(arguments.length == 1) {
            pattern = new earb.pattern(this, p1);
            return pattern;
        }
    } 
    
    this.controller = function() {
        return new earb.channelController(this);
    }
    
    this.saveData = function() {
        var id = channelParams.store;
        if(id) {
            var data = {
                pattern: pattern.serialize()
            };
            localStorage.setItem("earb/pattern/" + id, JSON.stringify(data));
        }
    }
    
    this.loadData = function() {
        var id = channelParams.store;
        if(id) {
            var data = localStorage.getItem("earb/pattern/" + id);
            if(data) {
                data = JSON.parse(data);
                return data;
            }
        }
    }
    
    this.init();

}
    
