$(function() {
    
    var song = new earb({
        bpm: 60
    });

    var instrument = song.instrument();
    instrument.html();
    var x = instrument.pattern(4)
    .at(0).note({
        degree: 1,
        duration: 1
    }).at(1).note({
        degree: 2,
        duration: 1
    }).at(2).note({
        degree: 3,
        duration: 1
    }).at(3).note({
        degree: 4,
        duration: 1
    });


    
    
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