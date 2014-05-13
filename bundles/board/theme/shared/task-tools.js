$(function() {

    $(".g5zzd98up9").mod("init", function() {
    
        var container = $(this);
        mod.on("board/taskChanged", function(data) {
            container.html(data.toolbarLarge);
        });
    
    });
        
});
        