mod.init(".tf92Pms9UG", function() {

    var $container = $(this);
    
    mod.on("board/taskChanged", function(data) {
        $container.find(".status").text(data.statusText);
    }, $container);
    
});