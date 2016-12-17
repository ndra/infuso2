mod(".nRjkjN8GAn").init(function() {
    
    var $container = $(this);
    var $content = $container.children(".content");
    var $nodes = $content.children(".nodes");
    var $header = $container.children(".header");
    
    var data = {};
    try {
        data = JSON.parse(sessionStorage.getItem("song"));
    } catch(ex) {}

    var song = new earb.Song(data);
    
    song.on("addNode", function(node) {
        var $e = $("<div>").appendTo($nodes);
        node.view.render($e);
    });
    
    for(var i in earb.nodeTypes) {
        var type = earb.nodeTypes[i];
        var label = type.nodeClassLabel();
        $("<div>")
            .html(label)
            .appendTo($header)
            .data("type", i)
            .click(function() {
                song.addNode({
                    type: $(this).data("type")
                });
            });
    }
    
    setInterval(function() {
        var data = song.storeParams();
        sessionStorage.setItem("song", JSON.stringify(data));
    }, 1000);
    
    
    //song.addNode();
    //song.addNode();

});