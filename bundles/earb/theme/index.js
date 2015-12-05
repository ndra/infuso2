$(function() {
    
    var bass = earb.instrument("bass");
    /*var minor = earb.scales.minor(0);
    var pattern = bass.pattern({
        pattern: [1,2,3,4],
    }, minor);
    pattern.play(); */

    var song = earb.song();
    song.frame(0,function() {
        mod.msg("Ололо! Начало песня");
        bass.playNote(1,500);
    });
    song.frame(1,function() {
        mod.msg("Первый фрейм!!!!");
        bass.playNote({
            note: 10,
            duration: 500
        });
    });
    song.frame(3,function() {
        mod.msg("Третий фрейм!!!!");
    });
    song.play();

});
