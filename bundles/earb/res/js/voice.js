earb.voice = function(context, instrument) {

    earb.makeListener(this);

    var gain;
    var releaseGain;
    var voice = this;
    
    var isPlaying = false;  

    this.init = function() {   
    
        gain = context.createGain();        
        gain.gain.value = 0;
        
        releaseGain = context.createGain();
        releaseGain.connect(gain);
        
        this.createOscillators();
    
    }                
    
    this.createOscillators = function() {
    
        // Создаем осцилляторы 
        this.on("start", function(params) {
        
            var osc1 = context.createOscillator();
            osc1.connect(releaseGain);   
            osc1.type = instrument.name() == "solo" ? 'sawtooth' : "sawtooth";
            osc1.frequency.value = params.note.frequency;
            osc1.start(); 
         
        });
        
    }
    
    this.init();

    /**
     * Играет ноту
     **/         
    this.play = function(note) {
    
        if(!(note instanceof earb.note)) {
            alert("voice.play() require note object");
        }     
    
        isPlaying = true;  
    
        var attackDuration = .003;
        var attackGain = 1;
        var decayDuration = .1;
        var decayGain = .8;
        var sustainDuration = 15;
        var sustainGain = 0;    
        
        this.fire("start", {
            note: note
        });
        
        var currentTime = context.currentTime;
        var dt = 0;
    
        gain.gain.setValueAtTime(0, currentTime);
        releaseGain.gain.setValueAtTime(1, currentTime);
        dt += attackDuration;
        gain.gain.linearRampToValueAtTime(attackGain, currentTime + dt);
        dt += decayDuration;
        gain.gain.linearRampToValueAtTime(decayGain, currentTime + dt);
        dt += sustainDuration;
        gain.gain.linearRampToValueAtTime(sustainGain, currentTime + dt);        
        
        setTimeout(function() {         
            voice.stop();         
        }, note.durationMs);
    
    }
    
    /**
     * Прекращает играть ноту
     **/         
    this.stop = function() {     
        var releaseDuration = .1;    
        var currentTime = context.currentTime;   
        releaseGain.gain.setValueAtTime(1, currentTime);     
        releaseGain.gain.linearRampToValueAtTime(0, currentTime + releaseDuration); 
        setTimeout(function() {
            isPlaying = false;
            gain.disconnect();
        }, releaseDuration * 1000 + 1);   
    }
    
    this.isPlaying = function() {
        return isPlaying;
    }
    
    this.connect = function(destination) {
        gain.connect(destination);
    }
    
    this.animateFrequency = function(newFrequency, dt) {
    }

}