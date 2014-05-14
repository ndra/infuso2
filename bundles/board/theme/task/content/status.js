mod.init(".mnynzim4sj", function() {

    var container = $(this);
    
    mod.on("board/taskChanged", function(data) {
        container.find(".status-text").html(data.statusText)
    });

})