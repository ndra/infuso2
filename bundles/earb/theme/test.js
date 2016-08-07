$(function() {
    
    var song = new earb({
        bpm: 120
    });
    
    song.scale(earb.scales.blues(0));

    var channel = song.channel();
    var pattern = channel.pattern(16);
    channel.html();    
    
    $("<div>").css("height", 100).appendTo("body");
    
    var channel2 = song.channel({
        name: "solo"
    });
    var pattern = channel2.pattern(16);
    channel2.html(); 
    
    song.play();


});