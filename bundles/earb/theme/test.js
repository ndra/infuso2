$(function() {
    
    var song = new earb({
        bpm: 120
    });

    var instrument = song.instrument();
    var pattern = instrument.pattern(16);
    pattern.at(0).note({
        degree: 1,
        duration: 1
    });
    instrument.html();    
    
    $("<div>").css("height", 100).appendTo("body");
    
    var instrument2 = song.instrument();
    var pattern = instrument2.pattern(16);
    instrument2.html(); 
    
    //var voice = instrument.getFreeVoice();
    //var note = song.note();
    //voice.play(note);
    //var voice2 = instrument.getFreeVoice();
    //console.log(voice2);
    
    song.play();
    setTimeout(function() {
      //  song.stop();
    }, 10000);

});