$(function() {
    
    var song = new earb();
    var bass = song.instrument("bass");

    song.frame(0,function() {
        mod.msg("Ололо! Начало песня");
        
       // bass.playNote(1,500);
    });
    song.frame(1,function() {
        mod.msg("Первый фрейм!!!!");
        bass.pattern("Жопа жопа жопа жопа").start();

    });
    song.frame(3,function() {
        mod.msg("Третий фрейм!!!!");
    });
    song.play();
    
    $(window).blur(song.stop);

});
