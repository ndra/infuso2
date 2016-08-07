$(function() {
    
    var song = new earb({
        bpm: 120
    });
    
    song.scale(earb.scales.arabic(0));

    var instrument = song.instrument();
    var pattern = instrument.pattern(16);
    instrument.html();    
    
    $("<div>").css("height", 100).appendTo("body");
    
    var instrument2 = song.instrument({
        name: "solo"
    });
    var pattern = instrument2.pattern(16);
    instrument2.html(); 
    
    song.play();


});