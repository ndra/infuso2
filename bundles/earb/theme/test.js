$(function() {
    
    var song = new earb({
        bpm: 120
    });
    
    song.scale(earb.scales.hminor(0));

    var channel = song.channel({
        store: "mwDwlnhdL5",
        pattern: {
            numberOfSteps: 16    
        }
    });
    channel.controller().html();    
    
    /*$("<div>").css("height", 100).appendTo("body");
    
    var channel2 = song.channel({
        name: "solo"
    });
    var pattern = channel2.pattern(16);
    channel2.html();  */
    
    song.play();


});