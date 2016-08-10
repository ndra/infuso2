earb.instrument = function(song, context) {

    var voices = [];

    this.clearVoices = function() {
        var newVoices = [];
        for(var i in voices) {
            if(voices[i].isPlaying()) {
                newVoices.push(voices[i]);
            }
        }
        voices = newVoices;
    }     
       
    /**
     * Возвращает первый свободный голос
     **/                         
    this.getFreeVoice = function() {
        var voice = new earb.voice(song.audioContext, this);
        voice.connect(gain);
        voices.push(voice);
        return voice;
    }

}